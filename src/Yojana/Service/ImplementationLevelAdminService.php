<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ImplementationLevelAdminDto;
use Src\Yojana\Models\ImplementationLevel;

class ImplementationLevelAdminService
{
public function store(ImplementationLevelAdminDto $implementationLevelAdminDto){
    return ImplementationLevel::create([
        'title' => $implementationLevelAdminDto->title,
        'code' => $implementationLevelAdminDto->code,
        'threshold' => $implementationLevelAdminDto->threshold,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ImplementationLevel $implementationLevel, ImplementationLevelAdminDto $implementationLevelAdminDto){
    return tap($implementationLevel)->update([
        'title' => $implementationLevelAdminDto->title,
        'code' => $implementationLevelAdminDto->code,
        'threshold' => $implementationLevelAdminDto->threshold,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ImplementationLevel $implementationLevel){
    return tap($implementationLevel)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ImplementationLevel::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


