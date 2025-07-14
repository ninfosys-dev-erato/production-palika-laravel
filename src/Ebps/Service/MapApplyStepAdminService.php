<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ebps\DTO\MapApplyStepAdminDto;
use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;

class MapApplyStepAdminService
{
public function store(MapApplyStepAdminDto $mapApplyStepAdminDto){
    return MapApplyStep::create([
        'map_apply_id' => $mapApplyStepAdminDto->map_apply_id,
        'form_id' => $mapApplyStepAdminDto->form_id,
        'map_step_id' => $mapApplyStepAdminDto->map_step_id,
        'reviewed_by' => $mapApplyStepAdminDto->reviewed_by,
        'template' => $mapApplyStepAdminDto->template,
        'status' => $mapApplyStepAdminDto->status,
        'reason' => $mapApplyStepAdminDto->reason,
        'sent_to_approver_at' => $mapApplyStepAdminDto->sent_to_approver_at,
        'created_at' => date('Y-m-d H:i:s'),
        // 'created_by' => Auth::user()->id,
    ]);
}
public function update(MapApplyStep $mapApplyStep, MapApplyStepAdminDto $mapApplyStepAdminDto){
    return tap($mapApplyStep)->update([
        'map_apply_id' => $mapApplyStepAdminDto->map_apply_id,
        'form_id' => $mapApplyStepAdminDto->form_id,
        'map_step_id' => $mapApplyStepAdminDto->map_step_id,
        'reviewed_by' => $mapApplyStepAdminDto->reviewed_by,
        'template' => $mapApplyStepAdminDto->template,
        'status' => $mapApplyStepAdminDto->status,
        'reason' => $mapApplyStepAdminDto->reason,
        'sent_to_approver_at' => $mapApplyStepAdminDto->sent_to_approver_at,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapApplyStep $mapApplyStep){
    return tap($mapApplyStep)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapApplyStep::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function saveOrUpdate(MapApplyStepAdminDto $mapApplyStepAdminDto, $data=null)
{
    DB::beginTransaction();
    try{

    
    $mapApplyStepData = [
        'map_apply_id' => $mapApplyStepAdminDto->map_apply_id,
        'form_id' => $mapApplyStepAdminDto->form_id,
        'map_step_id' => $mapApplyStepAdminDto->map_step_id,
        'reviewed_by' => $mapApplyStepAdminDto->reviewed_by,
        'status' => MapApplyStatusEnum::PENDING->value,
        'reason' => $mapApplyStepAdminDto->reason,
    'sent_to_approver_at' => $mapApplyStepAdminDto->sent_to_approver_at,
    ];

    $mapApplyStep = MapApplyStep::updateOrCreate(
        [
            'map_apply_id' => $mapApplyStepAdminDto->map_apply_id,
            'form_id' => $mapApplyStepAdminDto->form_id,
            'map_step_id' => $mapApplyStepAdminDto->map_step_id,
        ],
        $mapApplyStepData + ['updated_at' => now(), 'updated_by' => Auth::id()]
    );

    $this->syncTemplates($mapApplyStep, $mapApplyStepAdminDto->template, $data);

    DB::commit();
    return $mapApplyStep;
} catch (\Exception $e) {
  
    logger($e);
    DB::rollBack();
}
}

private function syncTemplates($mapApplyStep, $template = null, $data = null)
{
        MapApplyStepTemplate::updateOrCreate(
            [
                'map_apply_step_id' => $mapApplyStep->id,
                'form_id' => $mapApplyStep->form_id
            ],
            [
                'template' => $template ?? null,
                'data' => json_encode($data),
                'updated_at' => now(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'created_by' => Auth::id(),
            ]
        );
    
}

}


