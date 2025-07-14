<?php

namespace Src\FuelSettings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FuelSettings\Models\VehicleCategory;

class VehicleCategoriesExport implements FromCollection
{
    public $vehicle_categories;

    public function __construct($vehicle_categories) {
        $this->vehicle_categories = $vehicle_categories;
    }

    public function collection()
    {
        return VehicleCategory::select([
'title',
'title_en'
])
        ->whereIn('id', $this->vehicle_categories)->get();
    }
}


