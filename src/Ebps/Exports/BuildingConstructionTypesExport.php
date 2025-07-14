<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\BuildingConstructionType;

class BuildingConstructionTypesExport implements FromCollection
{
    public $building_construction_types;

    public function __construct($building_construction_types) {
        $this->building_construction_types = $building_construction_types;
    }

    public function collection()
    {
        return BuildingConstructionType::select([
'title'
])
        ->whereIn('id', $this->building_construction_types)->get();
    }
}


