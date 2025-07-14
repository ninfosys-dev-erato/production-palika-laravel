<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\DistanceToWallAdminDto;
use Src\Ebps\Models\DistanceToWall;

class DistanceToWallAdminService
{
public function store(DistanceToWallAdminDto $distanceToWallAdminDto){
    return DistanceToWall::create([
        'map_apply_id' => $distanceToWallAdminDto->map_apply_id,
        'direction' => $distanceToWallAdminDto->direction,
        'has_road' => $distanceToWallAdminDto->has_road,
        'does_have_wall_door' => $distanceToWallAdminDto->does_have_wall_door,
        'dist_left' => $distanceToWallAdminDto->dist_left,
        'min_dist_left' => $distanceToWallAdminDto->min_dist_left,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(DistanceToWall $distanceToWall, DistanceToWallAdminDto $distanceToWallAdminDto){
    return tap($distanceToWall)->update([
        'map_apply_id' => $distanceToWallAdminDto->map_apply_id,
        'direction' => $distanceToWallAdminDto->direction,
        'has_road' => $distanceToWallAdminDto->has_road,
        'does_have_wall_door' => $distanceToWallAdminDto->does_have_wall_door,
        'dist_left' => $distanceToWallAdminDto->dist_left,
        'min_dist_left' => $distanceToWallAdminDto->min_dist_left,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(DistanceToWall $distanceToWall){
    return tap($distanceToWall)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    DistanceToWall::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function deleteByMapApplyId($mapApplyId)
{
    DistanceToWall::where('map_apply_id', $mapApplyId)->delete();
}
}


