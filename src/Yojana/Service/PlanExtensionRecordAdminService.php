<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PlanExtensionRecordAdminDto;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanExtensionRecord;

class PlanExtensionRecordAdminService
{
    public function store(PlanExtensionRecordAdminDto $planExtensionRecordAdminDto): PlanExtensionRecord
    {
        return PlanExtensionRecord::create([
            'plan_id' => $planExtensionRecordAdminDto->plan_id,
            'extension_date' => $planExtensionRecordAdminDto->extension_date,
            'previous_extension_date' => $planExtensionRecordAdminDto->previous_extension_date,
            'previous_completion_date' => $planExtensionRecordAdminDto->previous_completion_date,
            'letter_submission_date' => $planExtensionRecordAdminDto->letter_submission_date,
            'letter' => $planExtensionRecordAdminDto->letter,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(PlanExtensionRecord $planExtensionRecord, PlanExtensionRecordAdminDto $planExtensionRecordAdminDto): PlanExtensionRecord
    {
        return tap($planExtensionRecord)->update([
            'plan_id' => $planExtensionRecordAdminDto->plan_id,
            'extension_date' => $planExtensionRecordAdminDto->extension_date,
            'previous_extension_date' => $planExtensionRecordAdminDto->previous_extension_date,
            'previous_completion_date' => $planExtensionRecordAdminDto->previous_completion_date,
            'letter_submission_date' => $planExtensionRecordAdminDto->letter_submission_date,
            'letter' => $planExtensionRecordAdminDto->letter,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(PlanExtensionRecord $planExtensionRecord): PlanExtensionRecord
    {
        return tap($planExtensionRecord)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            PlanExtensionRecord::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
}


