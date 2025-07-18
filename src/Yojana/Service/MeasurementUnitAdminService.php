<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\MeasurementUnitAdminDto;
use Src\Yojana\Models\MeasurementUnit;

class MeasurementUnitAdminService
{
public function store(MeasurementUnitAdminDto $measurementUnitAdminDto){
    return MeasurementUnit::create([
        'type_id' => $measurementUnitAdminDto->type_id,
        'title' => $measurementUnitAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MeasurementUnit $measurementUnit, MeasurementUnitAdminDto $measurementUnitAdminDto){
    return tap($measurementUnit)->update([
        'type_id' => $measurementUnitAdminDto->type_id,
        'title' => $measurementUnitAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MeasurementUnit $measurementUnit){
    return tap($measurementUnit)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MeasurementUnit::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


