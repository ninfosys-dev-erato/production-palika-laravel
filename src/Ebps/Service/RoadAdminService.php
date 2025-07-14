<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\RoadAdminDto;
use Src\Ebps\Models\Road;

class RoadAdminService
{
public function store(RoadAdminDto $roadAdminDto){
    return Road::create([
        'map_apply_id' => $roadAdminDto->map_apply_id,
        'direction' => $roadAdminDto->direction,
        'width' => $roadAdminDto->width,
        'dist_from_middle' => $roadAdminDto->dist_from_middle,
        'min_dist_from_middle' => $roadAdminDto->min_dist_from_middle,
        'dist_from_side' => $roadAdminDto->dist_from_side,
        'min_dist_from_side' => $roadAdminDto->min_dist_from_side,
        'dist_from_right' => $roadAdminDto->dist_from_right,
        'min_dist_from_right' => $roadAdminDto->min_dist_from_right,
        'setback' => $roadAdminDto->setback,
        'min_setback' => $roadAdminDto->min_setback,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(Road $road, RoadAdminDto $roadAdminDto){
    return tap($road)->update([
        'map_apply_id' => $roadAdminDto->map_apply_id,
        'direction' => $roadAdminDto->direction,
        'width' => $roadAdminDto->width,
        'dist_from_middle' => $roadAdminDto->dist_from_middle,
        'min_dist_from_middle' => $roadAdminDto->min_dist_from_middle,
        'dist_from_side' => $roadAdminDto->dist_from_side,
        'min_dist_from_side' => $roadAdminDto->min_dist_from_side,
        'dist_from_right' => $roadAdminDto->dist_from_right,
        'min_dist_from_right' => $roadAdminDto->min_dist_from_right,
        'setback' => $roadAdminDto->setback,
        'min_setback' => $roadAdminDto->min_setback,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Road $road){
    return tap($road)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Road::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}


public function deleteByMapApplyId($mapApplyId)
{
    Road::where('map_apply_id', $mapApplyId)->delete();
}

}


