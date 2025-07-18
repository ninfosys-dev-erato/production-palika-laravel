<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapPassGroupAdminDto;
use Src\Ebps\Models\MapPassGroup;

class MapPassGroupAdminService
{
public function store(MapPassGroupAdminDto $mapPassGroupAdminDto){
    return MapPassGroup::create([
        'title' => $mapPassGroupAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapPassGroup $mapPassGroup, MapPassGroupAdminDto $mapPassGroupAdminDto){
    return tap($mapPassGroup)->update([
        'title' => $mapPassGroupAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapPassGroup $mapPassGroup){
    return tap($mapPassGroup)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapPassGroup::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


