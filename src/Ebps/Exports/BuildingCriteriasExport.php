<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\BuildingCriteria;

class BuildingCriteriasExport implements FromCollection
{
    public $building_criterias;

    public function __construct($building_criterias) {
        $this->building_criterias = $building_criterias;
    }

    public function collection()
    {
        return BuildingCriteria::select([
'min_gcr',
'min_far',
'min_dist_center',
'min_dist_side',
'min_dist_right',
'setback',
'dist_between_wall_and_boundaries',
'public_place_distance',
'cantilever_distance',
'high_tension_distance',
'is_active'
])
        ->whereIn('id', $this->building_criterias)->get();
    }
}


