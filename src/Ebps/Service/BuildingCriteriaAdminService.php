<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\BuildingCriteriaAdminDto;
use Src\Ebps\Livewire\BuildingCriteriaTable;
use Src\Ebps\Models\BuildingCriteria;

class BuildingCriteriaAdminService
{
public function store(BuildingCriteriaAdminDto $buildingCriteriaAdminDto){
    return BuildingCriteria::create([
        'min_gcr' => $buildingCriteriaAdminDto->min_gcr,
        'min_far' => $buildingCriteriaAdminDto->min_far,
        'min_dist_center' => $buildingCriteriaAdminDto->min_dist_center,
        'min_dist_side' => $buildingCriteriaAdminDto->min_dist_side,
        'min_dist_right' => $buildingCriteriaAdminDto->min_dist_right,
        'setback' => $buildingCriteriaAdminDto->setback,
        'dist_between_wall_and_boundaries' => $buildingCriteriaAdminDto->dist_between_wall_and_boundaries,
        'public_place_distance' => $buildingCriteriaAdminDto->public_place_distance,
        'cantilever_distance' => $buildingCriteriaAdminDto->cantilever_distance,
        'high_tension_distance' => $buildingCriteriaAdminDto->high_tension_distance,
        'is_active' => $buildingCriteriaAdminDto->is_active,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BuildingCriteria $buildingCriteria, BuildingCriteriaAdminDto $buildingCriteriaAdminDto){
    return tap($buildingCriteria)->update([
        'min_gcr' => $buildingCriteriaAdminDto->min_gcr,
        'min_far' => $buildingCriteriaAdminDto->min_far,
        'min_dist_center' => $buildingCriteriaAdminDto->min_dist_center,
        'min_dist_side' => $buildingCriteriaAdminDto->min_dist_side,
        'min_dist_right' => $buildingCriteriaAdminDto->min_dist_right,
        'setback' => $buildingCriteriaAdminDto->setback,
        'dist_between_wall_and_boundaries' => $buildingCriteriaAdminDto->dist_between_wall_and_boundaries,
        'public_place_distance' => $buildingCriteriaAdminDto->public_place_distance,
        'cantilever_distance' => $buildingCriteriaAdminDto->cantilever_distance,
        'high_tension_distance' => $buildingCriteriaAdminDto->high_tension_distance,
        'is_active' => $buildingCriteriaAdminDto->is_active,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BuildingCriteria $buildingCriteria){
    return tap($buildingCriteria)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BuildingCriteria::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

    public function toggleStatus(BuildingCriteria $buildingCriteria): void
    {
        $isActive = !$buildingCriteria->is_active;

        $buildingCriteria->update([
            'is_active' => $isActive,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }
}


