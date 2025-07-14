<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\BuildingRoofTypeAdminDto;
use Src\Ebps\Models\BuildingRoofType;

class BuildingRoofTypeAdminService
{
public function store(BuildingRoofTypeAdminDto $buildingRoofTypeAdminDto){
    return BuildingRoofType::create([
        'title' => $buildingRoofTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BuildingRoofType $buildingRoofType, BuildingRoofTypeAdminDto $buildingRoofTypeAdminDto){
    return tap($buildingRoofType)->update([
        'title' => $buildingRoofTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BuildingRoofType $buildingRoofType){
    return tap($buildingRoofType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BuildingRoofType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


