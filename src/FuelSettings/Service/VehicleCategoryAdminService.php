<?php

namespace Src\FuelSettings\Service;

use Illuminate\Support\Facades\Auth;
use Src\FuelSettings\DTO\VehicleCategoryAdminDto;
use Src\FuelSettings\Models\VehicleCategory;

class VehicleCategoryAdminService
{
public function store(VehicleCategoryAdminDto $vehicleCategoryAdminDto){
    return VehicleCategory::create([
        'title' => $vehicleCategoryAdminDto->title,
        'title_en' => $vehicleCategoryAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(VehicleCategory $vehicleCategory, VehicleCategoryAdminDto $vehicleCategoryAdminDto){
    return tap($vehicleCategory)->update([
        'title' => $vehicleCategoryAdminDto->title,
        'title_en' => $vehicleCategoryAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(VehicleCategory $vehicleCategory){
    return tap($vehicleCategory)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    VehicleCategory::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


