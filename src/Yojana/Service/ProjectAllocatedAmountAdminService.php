<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectAllocatedAmountAdminDto;
use Src\Yojana\Models\ProjectAllocatedAmount;

class ProjectAllocatedAmountAdminService
{
public function store(ProjectAllocatedAmountAdminDto $projectAllocatedAmountAdminDto){
    return ProjectAllocatedAmount::create([
        'project_id' => $projectAllocatedAmountAdminDto->project_id,
        'budget_head_id' => $projectAllocatedAmountAdminDto->budget_head_id,
        'amount' => $projectAllocatedAmountAdminDto->amount,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectAllocatedAmount $projectAllocatedAmount, ProjectAllocatedAmountAdminDto $projectAllocatedAmountAdminDto){
    return tap($projectAllocatedAmount)->update([
        'project_id' => $projectAllocatedAmountAdminDto->project_id,
        'budget_head_id' => $projectAllocatedAmountAdminDto->budget_head_id,
        'amount' => $projectAllocatedAmountAdminDto->amount,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectAllocatedAmount $projectAllocatedAmount){
    return tap($projectAllocatedAmount)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectAllocatedAmount::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


