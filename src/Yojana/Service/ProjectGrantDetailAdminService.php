<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectGrantDetailAdminDto;
use Src\Yojana\Models\ProjectGrantDetail;

class ProjectGrantDetailAdminService
{
public function store(ProjectGrantDetailAdminDto $projectGrantDetailAdminDto){
    return ProjectGrantDetail::create([
        'project_id' => $projectGrantDetailAdminDto->project_id,
        'grant_source' => $projectGrantDetailAdminDto->grant_source,
        'asset_name' => $projectGrantDetailAdminDto->asset_name,
        'quantity' => $projectGrantDetailAdminDto->quantity,
        'asset_unit' => $projectGrantDetailAdminDto->asset_unit,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectGrantDetail $projectGrantDetail, ProjectGrantDetailAdminDto $projectGrantDetailAdminDto){
    return tap($projectGrantDetail)->update([
        'project_id' => $projectGrantDetailAdminDto->project_id,
        'grant_source' => $projectGrantDetailAdminDto->grant_source,
        'asset_name' => $projectGrantDetailAdminDto->asset_name,
        'quantity' => $projectGrantDetailAdminDto->quantity,
        'asset_unit' => $projectGrantDetailAdminDto->asset_unit,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectGrantDetail $projectGrantDetail){
    return tap($projectGrantDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectGrantDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


