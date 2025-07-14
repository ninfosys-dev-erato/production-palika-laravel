<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CargoHandlingAdminDto;
use Src\Yojana\Models\CargoHandling;

class CargoHandlingAdminService
{
public function store(CargoHandlingAdminDto $cargoHandlingAdminDto){
    return CargoHandling::create([
        'fiscal_year_id' => $cargoHandlingAdminDto->fiscal_year_id,
        'unit_id' => $cargoHandlingAdminDto->unit_id,
        'material_id' => $cargoHandlingAdminDto->material_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CargoHandling $cargoHandling, CargoHandlingAdminDto $cargoHandlingAdminDto){
    return tap($cargoHandling)->update([
        'fiscal_year_id' => $cargoHandlingAdminDto->fiscal_year_id,
        'unit_id' => $cargoHandlingAdminDto->unit_id,
        'material_id' => $cargoHandlingAdminDto->material_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CargoHandling $cargoHandling){
    return tap($cargoHandling)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CargoHandling::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


