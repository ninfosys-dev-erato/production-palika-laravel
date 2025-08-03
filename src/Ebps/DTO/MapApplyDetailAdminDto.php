<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapApplyDetail;

class MapApplyDetailAdminDto
{
   public function __construct(
        public ?int $map_apply_id,
        public ?int $organization_id,
        public ?int $land_use_area_id,
        public ?string $land_use_area_changes,
        public ?string $usage_changes,
        public ?string $change_acceptance_type,
        public ?string $field_measurement_area,
        public ?string $building_plinth_area,
        public ?int $building_construction_type_id,
        public ?string $building_roof_type_id,
        public ?string $other_construction_area,
        public ?string $former_other_construction_area,
        public ?string $public_property_name,
        public ?string $material_used,
        public int|string|null $distance_left,
        public int|string|null $area_unit,
        public int|string|null $length_unit
    ){}

public static function fromLiveWireModel(MapApplyDetail $mapApplyDetail):MapApplyDetailAdminDto{
    return new self(
        map_apply_id: $mapApplyDetail->map_apply_id,
        organization_id: $mapApplyDetail->organization_id,
        land_use_area_id: $mapApplyDetail->land_use_area_id,
        land_use_area_changes: $mapApplyDetail->land_use_area_changes,
        usage_changes: $mapApplyDetail->usage_changes,
        change_acceptance_type: $mapApplyDetail->change_acceptance_type,
        field_measurement_area: $mapApplyDetail->field_measurement_area,
        building_plinth_area: $mapApplyDetail->building_plinth_area,
        building_construction_type_id: $mapApplyDetail->building_construction_type_id,
        building_roof_type_id: $mapApplyDetail->building_roof_type_id,
        other_construction_area: $mapApplyDetail->other_construction_area,
        former_other_construction_area: $mapApplyDetail->former_other_construction_area,
        public_property_name: $mapApplyDetail->public_property_name,
        material_used: $mapApplyDetail->material_used,
        distance_left: $mapApplyDetail->distance_left,
        area_unit: $mapApplyDetail->area_unit,
        length_unit: $mapApplyDetail->length_unit
    );
}
}
