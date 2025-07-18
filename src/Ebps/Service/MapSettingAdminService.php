<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapSettingAdminDto;
use Src\Ebps\Models\MapSetting;

class MapSettingAdminService
{
public function store(MapSettingAdminDto $mapSettingAdminDto){
    return MapSetting::create([
        'rate_according' => $mapSettingAdminDto->rate_according,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapSetting $mapSetting, MapSettingAdminDto $mapSettingAdminDto){
    return tap($mapSetting)->update([
        'rate_according' => $mapSettingAdminDto->rate_according,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapSetting $mapSetting){
    return tap($mapSetting)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapSetting::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


