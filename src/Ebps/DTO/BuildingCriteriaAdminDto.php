<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\BuildingCriteria;

class BuildingCriteriaAdminDto
{
   public function __construct(
        public string $min_gcr,
        public string $min_far,
        public string $min_dist_center,
        public string $min_dist_side,
        public string $min_dist_right,
        public string $setback,
        public string $dist_between_wall_and_boundaries,
        public string $public_place_distance,
        public string $cantilever_distance,
        public string $high_tension_distance,
        public bool $is_active
    ){}

public static function fromLiveWireModel(BuildingCriteria $buildingCriteria):BuildingCriteriaAdminDto{
    return new self(
        min_gcr: $buildingCriteria->min_gcr,
        min_far: $buildingCriteria->min_far,
        min_dist_center: $buildingCriteria->min_dist_center,
        min_dist_side: $buildingCriteria->min_dist_side,
        min_dist_right: $buildingCriteria->min_dist_right,
        setback: $buildingCriteria->setback,
        dist_between_wall_and_boundaries: $buildingCriteria->dist_between_wall_and_boundaries,
        public_place_distance: $buildingCriteria->public_place_distance,
        cantilever_distance: $buildingCriteria->cantilever_distance,
        high_tension_distance: $buildingCriteria->high_tension_distance,
        is_active: $buildingCriteria->is_active ?? false
    );
}
}
