<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\ProjectAdminDto;
use Src\TaskTracking\Models\Project;

class ProjectAdminService
{
public function store(ProjectAdminDto $projectAdminDto){
    return Project::create([
        'title' => $projectAdminDto->title,
        'description' => $projectAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Project $project, ProjectAdminDto $projectAdminDto){
    return tap($project)->update([
        'title' => $projectAdminDto->title,
        'description' => $projectAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Project $project){
    return tap($project)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Project::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


