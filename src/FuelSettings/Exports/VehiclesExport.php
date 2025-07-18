<?php

namespace Src\FuelSettings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FuelSettings\Models\Vehicle;

class VehiclesExport implements FromCollection
{
    public $vehicles;

    public function __construct($vehicles) {
        $this->vehicles = $vehicles;
    }

    public function collection()
    {
        return Vehicle::select([
'employee_id',
'vehicle_category_id',
'vehicle_number',
'chassis_number',
'engine_number',
'fuel_type',
'driver_name',
'license_number',
'license_photo',
'signature',
'driver_contact_no',
'vehicle_detail'
])
        ->whereIn('id', $this->vehicles)->get();
    }
}


