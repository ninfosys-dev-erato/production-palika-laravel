<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\FuelAdminDto;
use Src\Yojana\Models\Fuel;

class FuelAdminService
{
public function store(FuelAdminDto $fuelAdminDto){
    return Fuel::create([
        'title' => $fuelAdminDto->title,
        'unit_id' => $fuelAdminDto->unit_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Fuel $fuel, FuelAdminDto $fuelAdminDto){
    return tap($fuel)->update([
        'title' => $fuelAdminDto->title,
        'unit_id' => $fuelAdminDto->unit_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Fuel $fuel){
    return tap($fuel)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Fuel::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


