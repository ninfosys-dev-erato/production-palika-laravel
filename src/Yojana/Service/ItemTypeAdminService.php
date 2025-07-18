<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ItemTypeAdminDto;
use Src\Yojana\Models\ItemType;

class ItemTypeAdminService
{
public function store(ItemTypeAdminDto $itemTypeAdminDto){
    return ItemType::create([
        'title' => $itemTypeAdminDto->title,
        'code' => $itemTypeAdminDto->code,
        'group' => $itemTypeAdminDto->group,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ItemType $itemType, ItemTypeAdminDto $itemTypeAdminDto){
    return tap($itemType)->update([
        'title' => $itemTypeAdminDto->title,
        'code' => $itemTypeAdminDto->code,
        'group' => $itemTypeAdminDto->group,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ItemType $itemType){
    return tap($itemType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ItemType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


