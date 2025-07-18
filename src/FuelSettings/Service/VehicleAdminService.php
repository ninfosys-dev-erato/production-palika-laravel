<?php

namespace Src\FuelSettings\Service;

use Illuminate\Support\Facades\Auth;
use Src\FuelSettings\DTO\VehicleAdminDto;
use Src\FuelSettings\Models\Vehicle;

class VehicleAdminService
{
public function store(VehicleAdminDto $vehicleAdminDto){
    return Vehicle::create([
        'employee_id' => $vehicleAdminDto->employee_id,
        'vehicle_category_id' => $vehicleAdminDto->vehicle_category_id,
        'vehicle_number' => $vehicleAdminDto->vehicle_number,
        'chassis_number' => $vehicleAdminDto->chassis_number,
        'engine_number' => $vehicleAdminDto->engine_number,
        'fuel_type' => $vehicleAdminDto->fuel_type,
        'driver_name' => $vehicleAdminDto->driver_name,
        'license_number' => $vehicleAdminDto->license_number,
        'license_photo' => $vehicleAdminDto->license_photo,
        'signature' => $vehicleAdminDto->signature,
        'driver_contact_no' => $vehicleAdminDto->driver_contact_no,
        'vehicle_detail' => $vehicleAdminDto->vehicle_detail,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Vehicle $vehicle, VehicleAdminDto $vehicleAdminDto){
    return tap($vehicle)->update([
        'employee_id' => $vehicleAdminDto->employee_id,
        'vehicle_category_id' => $vehicleAdminDto->vehicle_category_id,
        'vehicle_number' => $vehicleAdminDto->vehicle_number,
        'chassis_number' => $vehicleAdminDto->chassis_number,
        'engine_number' => $vehicleAdminDto->engine_number,
        'fuel_type' => $vehicleAdminDto->fuel_type,
        'driver_name' => $vehicleAdminDto->driver_name,
        'license_number' => $vehicleAdminDto->license_number,
        'license_photo' => $vehicleAdminDto->license_photo,
        'signature' => $vehicleAdminDto->signature,
        'driver_contact_no' => $vehicleAdminDto->driver_contact_no,
        'vehicle_detail' => $vehicleAdminDto->vehicle_detail,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Vehicle $vehicle){
    return tap($vehicle)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Vehicle::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


