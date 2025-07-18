<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectGroupAdminDto;
use Src\Yojana\Models\ProjectGroup;

class ProjectGroupAdminService
{
public function store(ProjectGroupAdminDto $projectGroupAdminDto){
    return ProjectGroup::create([
        'title' => $projectGroupAdminDto->title,
        'group_id' => $projectGroupAdminDto->group_id,
        'area_id' => $projectGroupAdminDto->area_id,
        'code' => $projectGroupAdminDto->code,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectGroup $projectGroup, ProjectGroupAdminDto $projectGroupAdminDto){
    return tap($projectGroup)->update([
        'title' => $projectGroupAdminDto->title,
        'group_id' => $projectGroupAdminDto->group_id,
        'area_id' => $projectGroupAdminDto->area_id,
        'code' => $projectGroupAdminDto->code,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectGroup $projectGroup){
    return tap($projectGroup)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectGroup::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


