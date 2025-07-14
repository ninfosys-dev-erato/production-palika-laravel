<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\SourceTypeAdminDto;
use Src\Yojana\Models\SourceType;

class SourceTypeAdminService
{
public function store(SourceTypeAdminDto $sourceTypeAdminDto){
    return SourceType::create([
        'title' => $sourceTypeAdminDto->title,
        'code' => $sourceTypeAdminDto->code,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(SourceType $sourceType, SourceTypeAdminDto $sourceTypeAdminDto){
    return tap($sourceType)->update([
        'title' => $sourceTypeAdminDto->title,
        'code' => $sourceTypeAdminDto->code,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(SourceType $sourceType){
    return tap($sourceType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    SourceType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


