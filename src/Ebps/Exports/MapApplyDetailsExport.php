<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\MapApplyDetail;

class MapApplyDetailsExport implements FromCollection
{
    public $map_apply_details;

    public function __construct($map_apply_details) {
        $this->map_apply_details = $map_apply_details;
    }

    public function collection()
    {
        return MapApplyDetail::select([
'map_apply_id',
'organization_id',
'land_use_area_id',
'land_use_area_changes',
'usage_changes',
'change_acceptance_type',
'field_measurement_area',
'building_plinth_area',
'building_construction_type_id',
'building_roof_type_id',
'other_construction_area',
'former_other_construction_area',
'public_property_name',
'material_used',
'distance_left',
'area_unit',
'length_unit'
])
        ->whereIn('id', $this->map_apply_details)->get();
    }
}


