<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\LandUseArea;

class LandUseAreasExport implements FromCollection
{
    public $land_use_areas;

    public function __construct($land_use_areas) {
        $this->land_use_areas = $land_use_areas;
    }

    public function collection()
    {
        return LandUseArea::select([
'title'
])
        ->whereIn('id', $this->land_use_areas)->get();
    }
}


