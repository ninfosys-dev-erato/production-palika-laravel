<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\CourtSubmissionAdminDto;
use Src\Ejalas\Models\CourtSubmission;

class CourtSubmissionAdminService
{
public function store(CourtSubmissionAdminDto $courtSubmissionAdminDto){
    return CourtSubmission::create([
        'complaint_registration_id' => $courtSubmissionAdminDto->complaint_registration_id,
        'discussion_date' => $courtSubmissionAdminDto->discussion_date,
        'submission_decision_date' => $courtSubmissionAdminDto->submission_decision_date,
        'decision_authority_id' => $courtSubmissionAdminDto->decision_authority_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CourtSubmission $courtSubmission, CourtSubmissionAdminDto $courtSubmissionAdminDto){
    return tap($courtSubmission)->update([
        'complaint_registration_id' => $courtSubmissionAdminDto->complaint_registration_id,
        'discussion_date' => $courtSubmissionAdminDto->discussion_date,
        'submission_decision_date' => $courtSubmissionAdminDto->submission_decision_date,
        'decision_authority_id' => $courtSubmissionAdminDto->decision_authority_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CourtSubmission $courtSubmission){
    return tap($courtSubmission)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CourtSubmission::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


