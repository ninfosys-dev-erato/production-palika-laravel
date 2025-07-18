<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\CaseRecordAdminDto;
use Src\Ejalas\Models\CaseRecord;

class CaseRecordAdminService
{
    public function store(CaseRecordAdminDto $caseRecordAdminDto)
    {
        return CaseRecord::create([
            'complaint_registration_id' => $caseRecordAdminDto->complaint_registration_id,
            'discussion_date' => $caseRecordAdminDto->discussion_date,
            'decision_date' => $caseRecordAdminDto->decision_date,
            'decision_authority_id' => $caseRecordAdminDto->decision_authority_id,
            'recording_officer_name' => $caseRecordAdminDto->recording_officer_name,
            'recording_officer_position' => $caseRecordAdminDto->recording_officer_position,
            'remarks' => $caseRecordAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CaseRecord $caseRecord, CaseRecordAdminDto $caseRecordAdminDto)
    {
        return tap($caseRecord)->update([
            'complaint_registration_id' => $caseRecordAdminDto->complaint_registration_id,
            'discussion_date' => $caseRecordAdminDto->discussion_date,
            'decision_date' => $caseRecordAdminDto->decision_date,
            'decision_authority_id' => $caseRecordAdminDto->decision_authority_id,
            'recording_officer_name' => $caseRecordAdminDto->recording_officer_name,
            'recording_officer_position' => $caseRecordAdminDto->recording_officer_position,
            'remarks' => $caseRecordAdminDto->remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CaseRecord $caseRecord)
    {
        return tap($caseRecord)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CaseRecord::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
