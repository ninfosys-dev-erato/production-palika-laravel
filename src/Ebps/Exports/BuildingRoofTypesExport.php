<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\BuildingRoofType;

class BuildingRoofTypesExport implements FromCollection
{
    public $building_roof_types;

    public function __construct($building_roof_types) {
        $this->building_roof_types = $building_roof_types;
    }

    public function collection()
    {
        return BuildingRoofType::select([
'title'
])
        ->whereIn('id', $this->building_roof_types)->get();
    }
}


