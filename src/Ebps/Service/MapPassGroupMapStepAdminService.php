<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapPassGroupMapStepAdminDto;
use Src\Ebps\Models\MapPassGroupMapStep;

class MapPassGroupMapStepAdminService
{
public function store(MapPassGroupMapStepAdminDto $mapPassGroupMapStepAdminDto){
    return MapPassGroupMapStep::create([
        'map_step_id' => $mapPassGroupMapStepAdminDto->map_step_id,
        'map_pass_group_id' => $mapPassGroupMapStepAdminDto->map_pass_group_id,
        'type' => $mapPassGroupMapStepAdminDto->type,
        'position' => $mapPassGroupMapStepAdminDto->position,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapPassGroupMapStep $mapPassGroupMapStep, MapPassGroupMapStepAdminDto $mapPassGroupMapStepAdminDto){
    return tap($mapPassGroupMapStep)->update([
        'map_step_id' => $mapPassGroupMapStepAdminDto->map_step_id,
        'map_pass_group_id' => $mapPassGroupMapStepAdminDto->map_pass_group_id,
        'type' => $mapPassGroupMapStepAdminDto->type,
        'position' => $mapPassGroupMapStepAdminDto->position,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapPassGroupMapStep $mapPassGroupMapStep){
    return tap($mapPassGroupMapStep)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapPassGroupMapStep::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


