<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapStepAdminDto;
use Src\Ebps\Models\MapStep;

class MapStepAdminService
{
public function store(MapStepAdminDto $mapStepAdminDto){
    return MapStep::create([
        'title' => $mapStepAdminDto->title,
        'is_public' => $mapStepAdminDto->is_public,
        'can_skip' => $mapStepAdminDto->can_skip,
        'form_submitter' => $mapStepAdminDto->form_submitter,
        'form_position' => $mapStepAdminDto->form_position,
        'step_for' => $mapStepAdminDto->step_for,
        'application_type' => $mapStepAdminDto->application_type,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapStep $mapStep, MapStepAdminDto $mapStepAdminDto){
    return tap($mapStep)->update([
        'title' => $mapStepAdminDto->title,
        'is_public' => $mapStepAdminDto->is_public,
        'can_skip' => $mapStepAdminDto->can_skip,
        'form_submitter' => $mapStepAdminDto->form_submitter,
        'form_position' => $mapStepAdminDto->form_position,
        'step_for' => $mapStepAdminDto->step_for,
        'application_type' => $mapStepAdminDto->application_type,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapStep $mapStep){
    return tap($mapStep)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapStep::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


