<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\FuelDemandAdminDto;
use Src\Yojana\Models\FuelDemand;

class FuelDemandAdminService
{
public function store(FuelDemandAdminDto $fuelDemandAdminDto){
    return FuelDemand::create([
        'fuel_id' => $fuelDemandAdminDto->fuel_id,
        'equipment_id' => $fuelDemandAdminDto->equipment_id,
        'quantity' => $fuelDemandAdminDto->quantity,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(FuelDemand $fuelDemand, FuelDemandAdminDto $fuelDemandAdminDto){
    return tap($fuelDemand)->update([
        'fuel_id' => $fuelDemandAdminDto->fuel_id,
        'equipment_id' => $fuelDemandAdminDto->equipment_id,
        'quantity' => $fuelDemandAdminDto->quantity,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FuelDemand $fuelDemand){
    return tap($fuelDemand)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FuelDemand::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


