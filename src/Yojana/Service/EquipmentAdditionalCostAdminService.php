<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\EquipmentAdditionalCostAdminDto;
use Src\Yojana\Models\EquipmentAdditionalCost;

class EquipmentAdditionalCostAdminService
{
public function store(EquipmentAdditionalCostAdminDto $equipmentAdditionalCostAdminDto){
    return EquipmentAdditionalCost::create([
        'equipment_id' => $equipmentAdditionalCostAdminDto->equipment_id,
        'fiscal_year_id' => $equipmentAdditionalCostAdminDto->fiscal_year_id,
        'unit_id' => $equipmentAdditionalCostAdminDto->unit_id,
        'rate' => $equipmentAdditionalCostAdminDto->rate,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(EquipmentAdditionalCost $equipmentAdditionalCost, EquipmentAdditionalCostAdminDto $equipmentAdditionalCostAdminDto){
    return tap($equipmentAdditionalCost)->update([
        'equipment_id' => $equipmentAdditionalCostAdminDto->equipment_id,
        'fiscal_year_id' => $equipmentAdditionalCostAdminDto->fiscal_year_id,
        'unit_id' => $equipmentAdditionalCostAdminDto->unit_id,
        'rate' => $equipmentAdditionalCostAdminDto->rate,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(EquipmentAdditionalCost $equipmentAdditionalCost){
    return tap($equipmentAdditionalCost)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    EquipmentAdditionalCost::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


