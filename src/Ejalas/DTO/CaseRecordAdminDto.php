<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\CaseRecord;

class CaseRecordAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $discussion_date,
        public string $decision_date,
        public string $decision_authority_id,
        public string $recording_officer_name,
        public string $recording_officer_position,
        public string $remarks
    ) {}

    public static function fromLiveWireModel(CaseRecord $caseRecord): CaseRecordAdminDto
    {
        return new self(
            complaint_registration_id: $caseRecord->complaint_registration_id,
            discussion_date: $caseRecord->discussion_date,
            decision_date: $caseRecord->decision_date,
            decision_authority_id: $caseRecord->decision_authority_id,
            recording_officer_name: $caseRecord->recording_officer_name,
            recording_officer_position: $caseRecord->recording_officer_position,
            remarks: $caseRecord->remarks
        );
    }
}
