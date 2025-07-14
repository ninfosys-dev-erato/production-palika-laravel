<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ejalas\DTO\FulfilledConditionAdminDto;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Models\SettlementDetail;

class FulfilledConditionAdminService
{
    public function store(FulfilledConditionAdminDto $fulfilledConditionAdminDto)
    {
        try {
            DB::beginTransaction();
            $fulfilledCondition = FulfilledCondition::create([
                'complaint_registration_id' => $fulfilledConditionAdminDto->complaint_registration_id,
                'fulfilling_party' => $fulfilledConditionAdminDto->fulfilling_party,
                'condition' => $fulfilledConditionAdminDto->condition,
                'completion_details' => $fulfilledConditionAdminDto->completion_details,
                'completion_proof' => $fulfilledConditionAdminDto->completion_proof,
                'due_date' => $fulfilledConditionAdminDto->due_date,
                'completion_date' => $fulfilledConditionAdminDto->completion_date,
                'entered_by' => $fulfilledConditionAdminDto->entered_by,
                'entry_date' => $fulfilledConditionAdminDto->entry_date,
                'created_at' => now(),
                'created_by' => Auth::id(),
            ]);
            SettlementDetail::where('id', $fulfilledConditionAdminDto->condition)
                ->update(['is_settled' => true]);
            DB::commit();
            return $fulfilledCondition;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
    public function update(FulfilledCondition $fulfilledCondition, FulfilledConditionAdminDto $fulfilledConditionAdminDto)
    {

        return DB::transaction(function () use ($fulfilledCondition, $fulfilledConditionAdminDto) {
            $oldConditionId = FulfilledCondition::find($fulfilledCondition->id)->condition; //gets previous condition Id 
            tap($fulfilledCondition)->update([
                'complaint_registration_id' => $fulfilledConditionAdminDto->complaint_registration_id,
                'fulfilling_party' => $fulfilledConditionAdminDto->fulfilling_party,
                'condition' => $fulfilledConditionAdminDto->condition,
                'completion_details' => $fulfilledConditionAdminDto->completion_details,
                'completion_proof' => $fulfilledConditionAdminDto->completion_proof,
                'due_date' => $fulfilledConditionAdminDto->due_date,
                'completion_date' => $fulfilledConditionAdminDto->completion_date,
                'entered_by' => $fulfilledConditionAdminDto->entered_by,
                'entry_date' => $fulfilledConditionAdminDto->entry_date,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
            if ($oldConditionId !== $fulfilledConditionAdminDto->condition) { //checks if condition id is changed or not
                SettlementDetail::where('id', $oldConditionId)
                    ->update(['is_settled' => false]);               //updates previous condition settled status to false
                SettlementDetail::where('id', $fulfilledConditionAdminDto->condition)
                    ->update(['is_settled' => true]);
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
