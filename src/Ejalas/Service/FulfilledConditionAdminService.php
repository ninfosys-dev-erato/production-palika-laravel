<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ejalas\DTO\FulfilledConditionAdminDto;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Models\SettlementDetail;

class FulfilledConditionAdminService
{
    public function store(FulfilledConditionAdminDto $dto): FulfilledCondition
    {
        return DB::transaction(function () use ($dto) {
            $fulfilledCondition = FulfilledCondition::create([
                'complaint_registration_id' => $dto->complaint_registration_id,
                'fulfilling_party' => $dto->fulfilling_party,
                'condition' => $dto->condition,
                'completion_details' => $dto->completion_details,
                'completion_proof' => $dto->completion_proof,
                'due_date' => $dto->due_date,
                'completion_date' => $dto->completion_date,
                'entered_by' => $dto->entered_by,
                'entry_date' => $dto->entry_date,
                'entry_date_en' => $dto->entry_date_en,
                'created_at' => now(),
                'created_by' => Auth::id(),
            ]);

            SettlementDetail::where('id', $dto->condition)
                ->update(['is_settled' => true]);

            return $fulfilledCondition;
        });
    }

    public function update(FulfilledCondition $fulfilledCondition, FulfilledConditionAdminDto $dto): FulfilledCondition
    {
        return DB::transaction(function () use ($fulfilledCondition, $dto) {
            $oldConditionId = FulfilledCondition::find($fulfilledCondition->id)->condition;

    
       
            $fulfilledCondition->update([
                'complaint_registration_id' => $dto->complaint_registration_id,
                'fulfilling_party' => $dto->fulfilling_party,
                'condition' => $dto->condition,
                'completion_details' => $dto->completion_details,
                'completion_proof' => $dto->completion_proof,
                'due_date' => $dto->due_date,
                'completion_date' => $dto->completion_date,
                'entered_by' => $dto->entered_by,
                'entry_date' => $dto->entry_date,
                'entry_date_en' => $dto->entry_date_en,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);

            if ($oldConditionId != $dto->condition) {
                SettlementDetail::where('id', $oldConditionId)->update(['is_settled' => false]);
                SettlementDetail::where('id', $dto->condition)->update(['is_settled' => true]);
            }

            return $fulfilledCondition;
        });
    }

    public function delete(FulfilledCondition $fulfilledCondition)
    {
        return tap($fulfilledCondition)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        FulfilledCondition::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
