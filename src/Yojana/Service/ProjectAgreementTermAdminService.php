<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectAgreementTermAdminDto;
use Src\Yojana\Models\ProjectAgreementTerm;

class ProjectAgreementTermAdminService
{
public function store(ProjectAgreementTermAdminDto $projectAgreementTermAdminDto){
    return ProjectAgreementTerm::create([
        'project_id' => $projectAgreementTermAdminDto->project_id,
        'data' => $projectAgreementTermAdminDto->data,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectAgreementTerm $projectAgreementTerm, ProjectAgreementTermAdminDto $projectAgreementTermAdminDto){
    return tap($projectAgreementTerm)->update([
        'project_id' => $projectAgreementTermAdminDto->project_id,
        'data' => $projectAgreementTermAdminDto->data,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectAgreementTerm $projectAgreementTerm){
    return tap($projectAgreementTerm)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectAgreementTerm::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


