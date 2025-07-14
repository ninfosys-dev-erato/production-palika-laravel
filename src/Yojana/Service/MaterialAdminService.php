<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\MaterialAdminDto;
use Src\Yojana\Models\Material;

class MaterialAdminService
{
public function store(MaterialAdminDto $materialAdminDto){
    return Material::create([
        'material_type_id' => $materialAdminDto->material_type_id,
        'unit_id' => $materialAdminDto->unit_id,
        'title' => $materialAdminDto->title,
        'density' => $materialAdminDto->density,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Material $material, MaterialAdminDto $materialAdminDto){
    return tap($material)->update([
        'material_type_id' => $materialAdminDto->material_type_id,
        'unit_id' => $materialAdminDto->unit_id,
        'title' => $materialAdminDto->title,
        'density' => $materialAdminDto->density,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Material $material){
    return tap($material)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Material::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


