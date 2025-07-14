<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\BuildingConstructionTypeAdminDto;
use Src\Ebps\Models\BuildingConstructionType;

class BuildingConstructionTypeAdminService
{
public function store(BuildingConstructionTypeAdminDto $buildingConstructionTypeAdminDto){
    return BuildingConstructionType::create([
        'title' => $buildingConstructionTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BuildingConstructionType $buildingConstructionType, BuildingConstructionTypeAdminDto $buildingConstructionTypeAdminDto){
    return tap($buildingConstructionType)->update([
        'title' => $buildingConstructionTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BuildingConstructionType $buildingConstructionType){
    return tap($buildingConstructionType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BuildingConstructionType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


