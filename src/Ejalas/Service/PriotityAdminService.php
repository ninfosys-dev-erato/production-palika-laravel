<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\PriotityAdminDto;
use Src\Ejalas\Models\Priotity;

class PriotityAdminService
{
public function store(PriotityAdminDto $priotityAdminDto){
    return Priotity::create([
        'name' => $priotityAdminDto->name,
        'position' => $priotityAdminDto->position,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Priotity $priotity, PriotityAdminDto $priotityAdminDto){
    return tap($priotity)->update([
        'name' => $priotityAdminDto->name,
        'position' => $priotityAdminDto->position,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Priotity $priotity){
    return tap($priotity)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Priotity::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


