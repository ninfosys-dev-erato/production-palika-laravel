<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapRateAdminDto;
use Src\Ebps\Models\MapRate;

class MapRateAdminService
{
public function store(MapRateAdminDto $mapRateAdminDto){
    return MapRate::create([
        'rateable_type' => $mapRateAdminDto->rateable_type,
        'rateable_id' => $mapRateAdminDto->rateable_id,
        'rate' => $mapRateAdminDto->rate,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapRate $mapRate, MapRateAdminDto $mapRateAdminDto){
    return tap($mapRate)->update([
        'rateable_type' => $mapRateAdminDto->rateable_type,
        'rateable_id' => $mapRateAdminDto->rateable_id,
        'rate' => $mapRateAdminDto->rate,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapRate $mapRate){
    return tap($mapRate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapRate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


