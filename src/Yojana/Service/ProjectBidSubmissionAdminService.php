<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectBidSubmissionAdminDto;
use Src\Yojana\Models\ProjectBidSubmission;

class ProjectBidSubmissionAdminService
{
public function store(ProjectBidSubmissionAdminDto $projectBidSubmissionAdminDto){
    return ProjectBidSubmission::create([
        'project_id' => $projectBidSubmissionAdminDto->project_id,
        'submission_type' => $projectBidSubmissionAdminDto->submission_type,
        'submission_no' => $projectBidSubmissionAdminDto->submission_no,
        'date' => $projectBidSubmissionAdminDto->date,
        'amount' => $projectBidSubmissionAdminDto->amount,
        'fiscal_year_id' => $projectBidSubmissionAdminDto->fiscal_year_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectBidSubmission $projectBidSubmission, ProjectBidSubmissionAdminDto $projectBidSubmissionAdminDto){
    return tap($projectBidSubmission)->update([
        'project_id' => $projectBidSubmissionAdminDto->project_id,
        'submission_type' => $projectBidSubmissionAdminDto->submission_type,
        'submission_no' => $projectBidSubmissionAdminDto->submission_no,
        'date' => $projectBidSubmissionAdminDto->date,
        'amount' => $projectBidSubmissionAdminDto->amount,
        'fiscal_year_id' => $projectBidSubmissionAdminDto->fiscal_year_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectBidSubmission $projectBidSubmission){
    return tap($projectBidSubmission)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectBidSubmission::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


