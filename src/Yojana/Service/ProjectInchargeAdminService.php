<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectInchargeAdminDto;
use Src\Yojana\Models\ProjectIncharge;

class ProjectInchargeAdminService
{
public function store(ProjectInchargeAdminDto $projectInchargeAdminDto){
    return ProjectIncharge::create([
        'employee_id' => $projectInchargeAdminDto->employee_id,
        'remarks' => $projectInchargeAdminDto->remarks,
        'plan_id' => $projectInchargeAdminDto->plan_id,
        'is_active' => $projectInchargeAdminDto->is_active,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectIncharge $projectIncharge, ProjectInchargeAdminDto $projectInchargeAdminDto){
    return tap($projectIncharge)->update([
        'employee_id' => $projectInchargeAdminDto->employee_id,
        'remarks' => $projectInchargeAdminDto->remarks,
        'plan_id' => $projectInchargeAdminDto->plan_id,
        'is_active' => $projectInchargeAdminDto->is_active,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectIncharge $projectIncharge){
    return tap($projectIncharge)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectIncharge::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


