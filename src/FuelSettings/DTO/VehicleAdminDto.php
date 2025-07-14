<?php

namespace Src\FuelSettings\DTO;

use Src\FuelSettings\Models\Vehicle;

class VehicleAdminDto
{
   public function __construct(
        public string $employee_id,
        public string $vehicle_category_id,
        public string $vehicle_number,
        public string $chassis_number,
        public string $engine_number,
        public string $fuel_type,
        public string $driver_name,
        public string $license_number,
        public string $license_photo,
        public string $signature,
        public string $driver_contact_no,
        public string $vehicle_detail
    ){}

public static function fromLiveWireModel(Vehicle $vehicle):VehicleAdminDto{
    return new self(
        employee_id: $vehicle->employee_id,
        vehicle_category_id: $vehicle->vehicle_category_id,
        vehicle_number: $vehicle->vehicle_number,
        chassis_number: $vehicle->chassis_number,
        engine_number: $vehicle->engine_number,
        fuel_type: $vehicle->fuel_type,
        driver_name: $vehicle->driver_name,
        license_number: $vehicle->license_number,
        license_photo: $vehicle->license_photo,
        signature: $vehicle->signature,
        driver_contact_no: $vehicle->driver_contact_no,
        vehicle_detail: $vehicle->vehicle_detail
    );
}
}
