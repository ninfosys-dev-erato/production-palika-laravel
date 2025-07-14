<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectDeadlineExtensionAdminDto;
use Src\Yojana\Models\ProjectDeadlineExtension;

class ProjectDeadlineExtensionAdminService
{
public function store(ProjectDeadlineExtensionAdminDto $projectDeadlineExtensionAdminDto){
    return ProjectDeadlineExtension::create([
        'project_id' => $projectDeadlineExtensionAdminDto->project_id,
        'extended_date' => $projectDeadlineExtensionAdminDto->extended_date,
        'en_extended_date' => $projectDeadlineExtensionAdminDto->en_extended_date,
        'submitted_date' => $projectDeadlineExtensionAdminDto->submitted_date,
        'en_submitted_date' => $projectDeadlineExtensionAdminDto->en_submitted_date,
        'remarks' => $projectDeadlineExtensionAdminDto->remarks,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectDeadlineExtension $projectDeadlineExtension, ProjectDeadlineExtensionAdminDto $projectDeadlineExtensionAdminDto){
    return tap($projectDeadlineExtension)->update([
        'project_id' => $projectDeadlineExtensionAdminDto->project_id,
        'extended_date' => $projectDeadlineExtensionAdminDto->extended_date,
        'en_extended_date' => $projectDeadlineExtensionAdminDto->en_extended_date,
        'submitted_date' => $projectDeadlineExtensionAdminDto->submitted_date,
        'en_submitted_date' => $projectDeadlineExtensionAdminDto->en_submitted_date,
        'remarks' => $projectDeadlineExtensionAdminDto->remarks,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectDeadlineExtension $projectDeadlineExtension){
    return tap($projectDeadlineExtension)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectDeadlineExtension::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


