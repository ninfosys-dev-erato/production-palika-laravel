<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\UnitAdminDto;
use Src\Yojana\Models\Unit;

class UnitAdminService
{
public function store(UnitAdminDto $unitAdminDto){
    return Unit::create([
        'symbol' => $unitAdminDto->symbol,
        'title' => $unitAdminDto->title,
        'title_ne' => $unitAdminDto->title_ne,
        'type_id' => $unitAdminDto->type_id,
        'will_be_in_use' => $unitAdminDto->will_be_in_use,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Unit $unit, UnitAdminDto $unitAdminDto){
    return tap($unit)->update([
        'symbol' => $unitAdminDto->symbol,
        'title' => $unitAdminDto->title,
        'title_ne' => $unitAdminDto->title_ne,
        'type_id' => $unitAdminDto->type_id,
        'will_be_in_use' => $unitAdminDto->will_be_in_use,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Unit $unit){
    return tap($unit)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Unit::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


