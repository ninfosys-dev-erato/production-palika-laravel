<?php

namespace Src\FileTracking\Service;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\FileTracking\DTO\FileRecordAdminDto;
use Src\FileTracking\Enums\PatracharStatus;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\FileRecordLog;

class PatracharService
{
    public function composeMessage(FileRecord $fileRecord,array $receipents)
    {
        try{
            $enDepartments = [];
            $neDepartments = [];
            DB::beginTransaction();
            $receipents = collect($receipents)->map(function ($recipient) use (&$enDepartments, &$neDepartments) {
                [$recipientType, $recipientId] = explode('_', $recipient);
                $model = $recipientType::find($recipientId);
                switch ($recipientType) {
                    case "Src\Wards\Models\Ward":
                        $enDepartments[] = $model->ward_name_en ?? "Ward: {$recipientId}";
                        $neDepartments[] = $model->ward_name_ne ?? "वडा: {$recipientId}";
                        break;

                    case "Src\Employees\Models\Branch":
                        $enDepartments[] = $model->title_en ?? "Branch: {$recipientId}";
                        $neDepartments[] = $model->title ?? "शाखा: {$recipientId}";
                        break;
                }

                return $model;
            })->filter();

            $departments = [
                'en' => implode(', ', $enDepartments),
                'ne' => implode(', ', $neDepartments),
            ];

            $fileRecord->departments = json_encode($departments);
            $fileRecord->fiscal_year = key(getSettingWithKey('fiscal-year'));
           
            $sender = Auth::guard('web')->user();
            // Create the primary record
            $primaryRecord = FileRecord::create($fileRecord->toArray());
           
            // Forward to all recipients as per forwardFile logic
            $this->forwardFile($primaryRecord, $receipents);

            $primaryRecord->sender_type = get_class($sender);
            $primaryRecord->sender_id = $sender->id;
            $primaryRecord->save();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception;
        }

    }
    public function forwardFile(FileRecord $fileRecord,Collection $models)
    {
        $threadId = $fileRecord->id;
        foreach ($models as $model) {
            $newFileRecord = $fileRecord->replicate(); //clone
            $newFileRecord->main_thread_id = $threadId; // Track original file
            
            $newFileRecord->patrachar_status = PatracharStatus::FORWARDED;
            $newFileRecord->recipient_type = get_class($model);
            $newFileRecord->recipient_id = $model->id;
            $newFileRecord->fiscal_year = key(getSettingWithKey('fiscal-year'));
            switch ($newFileRecord->recipient_type) {
                case "Src\Wards\Models\Ward":
                    $newFileRecord->ward = $model->id;
                    break;
                case "Src\Employees\Model\Branch":
                    $newFileRecord->departments = $model->id;
                    break;
            }
            $newFileRecord->save();
        }
    }

    public function farsyautFile(FileRecord $fileRecord)
    {
       return tap($fileRecord)->update([
           "patrachar_status" => PatracharStatus::FARSYAUT,
           "is_farsyaut"      => true,
       ]);

    }
}