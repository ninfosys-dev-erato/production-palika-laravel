<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\Models\MapApplyDetail;

class MapApplyDetailAdminService
{
public function store(MapApplyDetailAdminDto $mapApplyDetailAdminDto){
    return MapApplyDetail::create([
        'map_apply_id' => $mapApplyDetailAdminDto->map_apply_id,
        'organization_id' => $mapApplyDetailAdminDto->organization_id,
        'land_use_area_id' => $mapApplyDetailAdminDto->land_use_area_id,
        'land_use_area_changes' => $mapApplyDetailAdminDto->land_use_area_changes,
        'usage_changes' => $mapApplyDetailAdminDto->usage_changes,
        'change_acceptance_type' => $mapApplyDetailAdminDto->change_acceptance_type,
        'field_measurement_area' => $mapApplyDetailAdminDto->field_measurement_area,
        'building_plinth_area' => $mapApplyDetailAdminDto->building_plinth_area,
        'building_construction_type_id' => $mapApplyDetailAdminDto->building_construction_type_id,
        'building_roof_type_id' => $mapApplyDetailAdminDto->building_roof_type_id,
        'other_construction_area' => $mapApplyDetailAdminDto->other_construction_area,
        'former_other_construction_area' => $mapApplyDetailAdminDto->former_other_construction_area,
        'public_property_name' => $mapApplyDetailAdminDto->public_property_name,
        'material_used' => $mapApplyDetailAdminDto->material_used,
        'distance_left' => $mapApplyDetailAdminDto->distance_left,
        'area_unit' => $mapApplyDetailAdminDto->area_unit,
        'length_unit' => $mapApplyDetailAdminDto->length_unit,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(MapApplyDetail $mapApplyDetail, MapApplyDetailAdminDto $mapApplyDetailAdminDto){
    return tap($mapApplyDetail)->update([
        'map_apply_id' => $mapApplyDetailAdminDto->map_apply_id,
        'organization_id' => $mapApplyDetailAdminDto->organization_id,
        'land_use_area_id' => $mapApplyDetailAdminDto->land_use_area_id,
        'land_use_area_changes' => $mapApplyDetailAdminDto->land_use_area_changes,
        'usage_changes' => $mapApplyDetailAdminDto->usage_changes,
        'change_acceptance_type' => $mapApplyDetailAdminDto->change_acceptance_type,
        'field_measurement_area' => $mapApplyDetailAdminDto->field_measurement_area,
        'building_plinth_area' => $mapApplyDetailAdminDto->building_plinth_area,
        'building_construction_type_id' => $mapApplyDetailAdminDto->building_construction_type_id,
        'building_roof_type_id' => $mapApplyDetailAdminDto->building_roof_type_id,
        'other_construction_area' => $mapApplyDetailAdminDto->other_construction_area,
        'former_other_construction_area' => $mapApplyDetailAdminDto->former_other_construction_area,
        'public_property_name' => $mapApplyDetailAdminDto->public_property_name,
        'material_used' => $mapApplyDetailAdminDto->material_used,
        'distance_left' => $mapApplyDetailAdminDto->distance_left,
        'area_unit' => $mapApplyDetailAdminDto->area_unit,
        'length_unit' => $mapApplyDetailAdminDto->length_unit,
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
}
public function delete(MapApplyDetail $mapApplyDetail){
    return tap($mapApplyDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapApplyDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


