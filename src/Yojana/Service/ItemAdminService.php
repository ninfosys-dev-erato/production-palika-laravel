<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ItemAdminDto;
use Src\Yojana\Models\Item;

class ItemAdminService
{
public function store(ItemAdminDto $itemAdminDto){
    return Item::create([
        'title' => $itemAdminDto->title,
        'type_id' => $itemAdminDto->type_id,
        'code' => $itemAdminDto->code,
        'unit_id' => $itemAdminDto->unit_id,
        'remarks' => $itemAdminDto->remarks,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Item $item, ItemAdminDto $itemAdminDto){
    return tap($item)->update([
        'title' => $itemAdminDto->title,
        'type_id' => $itemAdminDto->type_id,
        'code' => $itemAdminDto->code,
        'unit_id' => $itemAdminDto->unit_id,
        'remarks' => $itemAdminDto->remarks,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Item $item){
    return tap($item)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Item::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


