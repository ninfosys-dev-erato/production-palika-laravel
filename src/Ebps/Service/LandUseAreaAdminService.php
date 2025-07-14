<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\LandUseAreaAdminDto;
use Src\Ebps\Models\LandUseArea;

class LandUseAreaAdminService
{
public function store(LandUseAreaAdminDto $landUseAreaAdminDto){
    return LandUseArea::create([
        'title' => $landUseAreaAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LandUseArea $landUseArea, LandUseAreaAdminDto $landUseAreaAdminDto){
    return tap($landUseArea)->update([
        'title' => $landUseAreaAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LandUseArea $landUseArea){
    return tap($landUseArea)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LandUseArea::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


