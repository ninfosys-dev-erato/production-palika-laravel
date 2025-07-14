<?php

namespace Src\TokenTracking\Service;

use App\Facades\SmsServiceFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Employees\Models\Branch;
use Src\TokenTracking\DTO\RegisterTokenAdminDto;
use Src\TokenTracking\DTO\TokenHolderAdminDto;
use Src\TokenTracking\Enums\TokenStageEnum;
use Src\TokenTracking\Enums\TokenStatusEnum;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Models\RegisterTokenLog;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Models\TokenLog;
use Src\TokenTracking\Models\TokenStageStatus;

class RegisterTokenAdminService
{
    public function store(
        RegisterTokenAdminDto $registerTokenAdminDto,
        TokenHolderAdminDto $tokenHolderAdminDto,
        array $selectedDepartments
    ){
        DB::beginTransaction();
        try{
            $token =  RegisterToken::create([
                'token' => $registerTokenAdminDto->token,
                'token_purpose' => $registerTokenAdminDto->token_purpose,
                'fiscal_year' => $registerTokenAdminDto->fiscal_year,
                'status' => TokenStatusEnum::COMPLETE,
                'date' => $registerTokenAdminDto->date,
                'date_en' => $registerTokenAdminDto->date_en,
                'branches' => $registerTokenAdminDto->branches,
                'current_branch' => $registerTokenAdminDto->current_branch,
                'stage' => TokenStageEnum::ENTRY,
                'entry_time' => $registerTokenAdminDto->entry_time,
                'exit_time' => $registerTokenAdminDto->exit_time,
                'estimated_time' => $registerTokenAdminDto->estimated_time,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
            ]);
            $token->branches()->sync($selectedDepartments);
            TokenHolder::create([
                'token_id'=>$token->id,
                'name'=>$tokenHolderAdminDto->name,
                'email'=>$tokenHolderAdminDto->email,
                'mobile_no'=>$tokenHolderAdminDto->mobile_no,
                'address'=>$tokenHolderAdminDto->address,
            ]);

            foreach (TokenStageEnum::cases() as $stage) {
               TokenStageStatus::create([
                    'token_id' => $token->id,
                    'branch' => $token->current_branch,
                    'stage' => $stage->value,
                    'status' => $stage === TokenStageEnum::ENTRY ? 'complete' : 'null',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            return $token;
        }catch (\Exception $exception){
            DB::rollback();
            return false;
        }
    }
    public function update(
        RegisterToken $registerToken,
                           RegisterTokenAdminDto $registerTokenAdminDto,
                           TokenHolderAdminDto $tokenHolderAdminDto,
                           array $selectedDepartments
    ){
        DB::beginTransaction();
        try{

            $oldBranch = $registerToken->getOriginal('current_branch'); 
            $newBranch = $registerTokenAdminDto->current_branch;

            TokenHolder::where('token_id',$registerToken->id)->update([
                'name'=>$tokenHolderAdminDto->name,
                'email'=>$tokenHolderAdminDto->email,
                'mobile_no'=>$tokenHolderAdminDto->mobile_no,
                'address'=>$tokenHolderAdminDto->address,
            ]);
            $registerToken->branches()->delete();
            $registerToken->branches()->sync($selectedDepartments);

            $currentBranchChanged = $oldBranch !== $newBranch;

            tap($registerToken)->update([
                'token' => $registerTokenAdminDto->token,
                'token_purpose' => $registerTokenAdminDto->token_purpose,
                'fiscal_year' => $registerTokenAdminDto->fiscal_year,
                'status' => TokenStatusEnum::PROCESSING,
                'date' => $registerTokenAdminDto->date,
                'date_en' => $registerTokenAdminDto->date_en,
                'branches' => $registerTokenAdminDto->branches,
                'current_branch' => $registerTokenAdminDto->current_branch,
                'stage' => TokenStageEnum::ENTRY,
                'entry_time' => $registerTokenAdminDto->entry_time,
                'exit_time' => $registerTokenAdminDto->exit_time,
                'estimated_time' => $registerTokenAdminDto->estimated_time,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);


            if ($currentBranchChanged) {
                TokenLog::create([
                    'token_id' => $registerToken->id,
                    'old_status' => $registerToken->getOriginal('status'),
                    'new_status' => $registerToken->status,
                    'old_stage' => TokenStatusEnum::PROCESSING,
                    'new_stage' => TokenStageEnum::ENTRY,
                    'old_branch' => $oldBranch,  
                    'new_branch' => $newBranch,
                    'created_at' => now(),
                    'created_by' => Auth::user()->id,
                ]);
            }
            DB::commit();
            return $registerToken;
        }catch(\Exception $exception){
            DB::rollback();
        }
    }
    public function delete(RegisterToken $registerToken){
        return tap($registerToken)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        RegisterToken::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function updateStatus(RegisterToken $registerToken, TokenStatusEnum $tokenStatusEnum):bool
    {
        DB::beginTransaction();
        try {
            $registerToken->update([
                'status' => $tokenStatusEnum,
            ]);
    
            TokenStageStatus::where('token_id', $registerToken->id)
                ->where('stage', $registerToken->stage)
                ->update([
                    'status' => $tokenStatusEnum,
                    'updated_at' => now()
                ]);

    
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }
    }

    public function updateStage(RegisterToken $registerToken, TokenStageEnum $tokenStageEnum):bool
    {
        DB::beginTransaction();
        try {
           $token =  $this->moveToNextStage($registerToken, $tokenStageEnum->value);

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }
    }

    public function updateBranch(RegisterToken $registerToken,int $newBranch):bool
    {
        DB::beginTransaction();
        try {
            $token = RegisterToken::findOrFail($registerToken->id);
            $token->update(['current_branch' => $newBranch]);
            DB::commit();
            return true;
    
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Branch update failed: ' . $e->getMessage());
            return false;
        }
    }

    public function moveToNextStage(RegisterToken $token, $selectedStage)
    {
        DB::beginTransaction();
        try {
            $stages = TokenStageEnum::cases();
            $currentStageIndex = array_search($token->stage, array_column($stages, 'value'));
            $selectedStageIndex = array_search($selectedStage, array_column($stages, 'value'));
    
            if ($selectedStageIndex === false || $currentStageIndex === false) {
                throw new \Exception('Invalid stage selection.');
            }
            for ($i = $currentStageIndex + 1; $i <= $selectedStageIndex; $i++) {
                $stageToUpdate = $stages[$i]->value;
    
                TokenStageStatus::where('token_id', $token->id)
                    ->where('stage', $stageToUpdate)
                    ->update([
                        'status' => ($i == $selectedStageIndex) ? TokenStatusEnum::PROCESSING : TokenStatusEnum::SKIPPING,
                        'updated_at' => now()
                    ]);
            }
            TokenStageStatus::where('token_id', $token->id)
                ->where('stage', $token->stage)
                ->update([
                    'status' => TokenStatusEnum::COMPLETE,
                    'updated_at' => now()
                ]);

            $token->update(['stage' => $selectedStage, 'status' => TokenStatusEnum::PROCESSING]);
    
            DB::commit();
            return $token;
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
        }
    }

    public function tokenCreateMessage(RegisterToken $registerToken): bool
    {
        try {
            $registerToken->loadMissing('tokenHolder');

            $mobile = $registerToken->tokenHolder->mobile_no ?? null;

            if (!$mobile) {
                logger()->warning("No mobile number found for token holder of token ID {$registerToken->id}");
                return false;
            }

            $holderName = $registerToken->tokenHolder->name ?? 'प्रयोगकर्ता';
            $token = $registerToken->token;
            $purpose = $registerToken->token_purpose->label();
            $feedbackUrl = config('app.url') . '/token-feedback';

            $message = "टोकन नं. {$token} {$purpose} का लागि तपाईँको तर्फबाट {$holderName} द्वारा लिइएको छ। धन्यवाद। कृपया आफ्नो प्रतिक्रिया दिन {$feedbackUrl} मा जानुहोस्।";

            return SmsServiceFacade::sendSms(recipient: $mobile, message: $message);
        } catch (\Throwable $e) {
            logger()->error('Token SMS sending failed', [
                'error' => $e->getMessage(),
                'token_id' => $registerToken->id ?? null,
            ]);
            return false;
        }
    }

}