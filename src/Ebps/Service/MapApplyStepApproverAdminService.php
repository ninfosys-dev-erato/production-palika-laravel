<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapApplyStepApproverAdminDto;
use Src\Ebps\Models\MapApplyStepApprover;

class MapApplyStepApproverAdminService
{
public function store(MapApplyStepApproverAdminDto $mapApplyStepApproverAdminDto){
    return MapApplyStepApprover::create([
        'map_apply_step_id' => $mapApplyStepApproverAdminDto->map_apply_step_id,
        'map_pass_group_id' => $mapApplyStepApproverAdminDto->map_pass_group_id ?? null,
        'user_id' => $mapApplyStepApproverAdminDto->user_id,
        'status' => $mapApplyStepApproverAdminDto->status,
        'reason' => $mapApplyStepApproverAdminDto->reason,
        'type' => $mapApplyStepApproverAdminDto->type,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapApplyStepApprover $mapApplyStepApprover, MapApplyStepApproverAdminDto $mapApplyStepApproverAdminDto){
    return tap($mapApplyStepApprover)->update([
        'map_apply_step_id' => $mapApplyStepApproverAdminDto->map_apply_step_id,
        'map_pass_group_id' => $mapApplyStepApproverAdminDto->map_pass_group_id,
        'user_id' => $mapApplyStepApproverAdminDto->user_id,
        'status' => $mapApplyStepApproverAdminDto->status,
        'reason' => $mapApplyStepApproverAdminDto->reason,
        'type' => $mapApplyStepApproverAdminDto->type,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapApplyStepApprover $mapApplyStepApprover){
    return tap($mapApplyStepApprover)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapApplyStepApprover::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


