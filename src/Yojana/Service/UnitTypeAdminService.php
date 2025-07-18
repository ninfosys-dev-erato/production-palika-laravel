<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\UnitTypeAdminDto;
use Src\Yojana\Models\UnitType;

class UnitTypeAdminService
{
public function store(UnitTypeAdminDto $unitTypeAdminDto){
    return UnitType::create([
        'title' => $unitTypeAdminDto->title,
        'title_en' => $unitTypeAdminDto->title_en,
        'display_order' => $unitTypeAdminDto->display_order,
        'will_be_in_use' => $unitTypeAdminDto->will_be_in_use,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(UnitType $unitType, UnitTypeAdminDto $unitTypeAdminDto){
    return tap($unitType)->update([
        'title' => $unitTypeAdminDto->title,
        'title_en' => $unitTypeAdminDto->title_en,
        'display_order' => $unitTypeAdminDto->display_order,
        'will_be_in_use' => $unitTypeAdminDto->will_be_in_use,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(UnitType $unitType){
    return tap($unitType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    UnitType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


