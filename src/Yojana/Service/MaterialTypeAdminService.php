<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\MaterialTypeAdminDto;
use Src\Yojana\Models\MaterialType;

class MaterialTypeAdminService
{
public function store(MaterialTypeAdminDto $materialTypeAdminDto){
    return MaterialType::create([
        'title' => $materialTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MaterialType $materialType, MaterialTypeAdminDto $materialTypeAdminDto){
    return tap($materialType)->update([
        'title' => $materialTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MaterialType $materialType){
    return tap($materialType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MaterialType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


