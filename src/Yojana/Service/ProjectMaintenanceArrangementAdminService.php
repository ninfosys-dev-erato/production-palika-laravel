<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectMaintenanceArrangementAdminDto;
use Src\Yojana\Models\ProjectMaintenanceArrangement;

class ProjectMaintenanceArrangementAdminService
{
public function store(ProjectMaintenanceArrangementAdminDto $projectMaintenanceArrangementAdminDto){
    return ProjectMaintenanceArrangement::create([
        'project_id' => $projectMaintenanceArrangementAdminDto->project_id,
        'office_name' => $projectMaintenanceArrangementAdminDto->office_name,
        'public_service' => $projectMaintenanceArrangementAdminDto->public_service,
        'service_fee' => $projectMaintenanceArrangementAdminDto->service_fee,
        'from_fee_donation' => $projectMaintenanceArrangementAdminDto->from_fee_donation,
        'others' => $projectMaintenanceArrangementAdminDto->others,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectMaintenanceArrangement $projectMaintenanceArrangement, ProjectMaintenanceArrangementAdminDto $projectMaintenanceArrangementAdminDto){
    return tap($projectMaintenanceArrangement)->update([
        'project_id' => $projectMaintenanceArrangementAdminDto->project_id,
        'office_name' => $projectMaintenanceArrangementAdminDto->office_name,
        'public_service' => $projectMaintenanceArrangementAdminDto->public_service,
        'service_fee' => $projectMaintenanceArrangementAdminDto->service_fee,
        'from_fee_donation' => $projectMaintenanceArrangementAdminDto->from_fee_donation,
        'others' => $projectMaintenanceArrangementAdminDto->others,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectMaintenanceArrangement $projectMaintenanceArrangement){
    return tap($projectMaintenanceArrangement)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectMaintenanceArrangement::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


