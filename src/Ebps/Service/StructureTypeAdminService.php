<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\StructureTypeAdminDto;
use Src\Ebps\Models\StructureType;

class StructureTypeAdminService
{
public function store(StructureTypeAdminDto $structureTypeAdminDto){
    return StructureType::create([
        'title' => $structureTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(StructureType $structureType, StructureTypeAdminDto $structureTypeAdminDto){
    return tap($structureType)->update([
        'title' => $structureTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(StructureType $structureType){
    return tap($structureType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    StructureType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


