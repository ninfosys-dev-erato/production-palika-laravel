<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectBidSubmission;

class ProjectBidSubmissionAdminDto
{
   public function __construct(
        public string $project_id,
        public string $submission_type,
        public string $submission_no,
        public string $date,
        public string $amount,
        public string $fiscal_year_id
    ){}

public static function fromLiveWireModel(ProjectBidSubmission $projectBidSubmission):ProjectBidSubmissionAdminDto{
    return new self(
        project_id: $projectBidSubmission->project_id,
        submission_type: $projectBidSubmission->submission_type,
        submission_no: $projectBidSubmission->submission_no,
        date: $projectBidSubmission->date,
        amount: $projectBidSubmission->amount,
        fiscal_year_id: $projectBidSubmission->fiscal_year_id
    );
}
}
