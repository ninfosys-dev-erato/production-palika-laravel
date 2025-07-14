<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\EquipmentAdminDto;
use Src\Yojana\Models\Equipment;

class EquipmentAdminService
{
public function store(EquipmentAdminDto $equipmentAdminDto){
    return Equipment::create([
        'title' => $equipmentAdminDto->title,
        'activity' => $equipmentAdminDto->activity,
        'is_used_for_transport' => $equipmentAdminDto->is_used_for_transport,
        'capacity' => $equipmentAdminDto->capacity,
        'speed_with_out_load' => $equipmentAdminDto->speed_with_out_load,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Equipment $equipment, EquipmentAdminDto $equipmentAdminDto){
    return tap($equipment)->update([
        'title' => $equipmentAdminDto->title,
        'activity' => $equipmentAdminDto->activity,
        'is_used_for_transport' => $equipmentAdminDto->is_used_for_transport,
        'capacity' => $equipmentAdminDto->capacity,
        'speed_with_out_load' => $equipmentAdminDto->speed_with_out_load,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Equipment $equipment){
    return tap($equipment)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Equipment::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


