<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectActivityGroupAdminDto;
use Src\Yojana\Models\ProjectActivityGroup;

class ProjectActivityGroupAdminService
{
public function store(ProjectActivityGroupAdminDto $projectActivityGroupAdminDto){
    return ProjectActivityGroup::create([
        'title' => $projectActivityGroupAdminDto->title,
        'code' => $projectActivityGroupAdminDto->code,
        'group_id' => $projectActivityGroupAdminDto->group_id,
        'norms_type' => $projectActivityGroupAdminDto->norms_type,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectActivityGroup $projectActivityGroup, ProjectActivityGroupAdminDto $projectActivityGroupAdminDto){
    return tap($projectActivityGroup)->update([
        'title' => $projectActivityGroupAdminDto->title,
        'code' => $projectActivityGroupAdminDto->code,
        'group_id' => $projectActivityGroupAdminDto->group_id,
        'norms_type' => $projectActivityGroupAdminDto->norms_type,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectActivityGroup $projectActivityGroup){
    return tap($projectActivityGroup)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectActivityGroup::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


