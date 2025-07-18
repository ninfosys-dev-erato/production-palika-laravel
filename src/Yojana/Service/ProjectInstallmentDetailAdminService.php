<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectInstallmentDetailAdminDto;
use Src\Yojana\Models\ProjectInstallmentDetail;

class ProjectInstallmentDetailAdminService
{
public function store(ProjectInstallmentDetailAdminDto $projectInstallmentDetailAdminDto){
    return ProjectInstallmentDetail::create([
        'project_id' => $projectInstallmentDetailAdminDto->project_id,
        'installment_type' => $projectInstallmentDetailAdminDto->installment_type,
        'date' => $projectInstallmentDetailAdminDto->date,
        'amount' => $projectInstallmentDetailAdminDto->amount,
        'construction_material_quantity' => $projectInstallmentDetailAdminDto->construction_material_quantity,
        'remarks' => $projectInstallmentDetailAdminDto->remarks,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectInstallmentDetail $projectInstallmentDetail, ProjectInstallmentDetailAdminDto $projectInstallmentDetailAdminDto){
    return tap($projectInstallmentDetail)->update([
        'project_id' => $projectInstallmentDetailAdminDto->project_id,
        'installment_type' => $projectInstallmentDetailAdminDto->installment_type,
        'date' => $projectInstallmentDetailAdminDto->date,
        'amount' => $projectInstallmentDetailAdminDto->amount,
        'construction_material_quantity' => $projectInstallmentDetailAdminDto->construction_material_quantity,
        'remarks' => $projectInstallmentDetailAdminDto->remarks,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectInstallmentDetail $projectInstallmentDetail){
    return tap($projectInstallmentDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectInstallmentDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


