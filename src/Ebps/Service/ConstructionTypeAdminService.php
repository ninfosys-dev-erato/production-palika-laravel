<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\ConstructionTypeAdminDto;
use Src\Ebps\Models\ConstructionType;

class ConstructionTypeAdminService
{
public function store(ConstructionTypeAdminDto $constructionTypeAdminDto){
    return ConstructionType::create([
        'title' => $constructionTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ConstructionType $constructionType, ConstructionTypeAdminDto $constructionTypeAdminDto){
    return tap($constructionType)->update([
        'title' => $constructionTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ConstructionType $constructionType){
    return tap($constructionType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ConstructionType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


