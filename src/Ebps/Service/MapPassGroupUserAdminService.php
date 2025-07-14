<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapPassGroupUserAdminDto;
use Src\Ebps\Models\MapPassGroupUser;

class MapPassGroupUserAdminService
{
public function store(MapPassGroupUserAdminDto $mapPassGroupUserAdminDto){
    return MapPassGroupUser::create([
        'map_pass_group_id' => $mapPassGroupUserAdminDto->map_pass_group_id,
        'user_id' => $mapPassGroupUserAdminDto->user_id,
        'ward_no' => $mapPassGroupUserAdminDto->ward_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapPassGroupUser $mapPassGroupUser, MapPassGroupUserAdminDto $mapPassGroupUserAdminDto){
    return tap($mapPassGroupUser)->update([
        'map_pass_group_id' => $mapPassGroupUserAdminDto->map_pass_group_id,
        'user_id' => $mapPassGroupUserAdminDto->user_id,
        'ward_no' => $mapPassGroupUserAdminDto->ward_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapPassGroupUser $mapPassGroupUser){
    return tap($mapPassGroupUser)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapPassGroupUser::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


