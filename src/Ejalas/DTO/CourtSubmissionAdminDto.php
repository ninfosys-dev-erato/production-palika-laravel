<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\CourtSubmission;

class CourtSubmissionAdminDto
{
   public function __construct(
        public string $complaint_registration_id,
        public string $discussion_date,
          public string $discussion_date_en,
        public string $submission_decision_date,
        public string $decision_authority_id
    ){}

public static function fromLiveWireModel(CourtSubmission $courtSubmission):CourtSubmissionAdminDto{
    return new self(
        complaint_registration_id: $courtSubmission->complaint_registration_id,
        discussion_date: $courtSubmission->discussion_date,
             discussion_date_en: $courtSubmission->discussion_date_en,
        submission_decision_date: $courtSubmission->submission_decision_date,
        decision_authority_id: $courtSubmission->decision_authority_id
    );
}
}
