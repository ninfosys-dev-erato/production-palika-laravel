<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\LocalLevelAdminDto;
use Src\Ejalas\Models\LocalLevel;

class LocalLevelAdminService
{
public function store(LocalLevelAdminDto $localLevelAdminDto){
    return LocalLevel::create([
        'title' => $localLevelAdminDto->title,
        'short_title' => $localLevelAdminDto->short_title,
        'type' => $localLevelAdminDto->type,
        'province_id' => $localLevelAdminDto->province_id,
        'district_id' => $localLevelAdminDto->district_id,
        'local_body_id' => $localLevelAdminDto->local_body_id,
        'mobile_no' => $localLevelAdminDto->mobile_no,
        'email' => $localLevelAdminDto->email,
        'website' => $localLevelAdminDto->website,
        'position' => $localLevelAdminDto->position,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LocalLevel $localLevel, LocalLevelAdminDto $localLevelAdminDto){
    return tap($localLevel)->update([
        'title' => $localLevelAdminDto->title,
        'short_title' => $localLevelAdminDto->short_title,
        'type' => $localLevelAdminDto->type,
        'province_id' => $localLevelAdminDto->province_id,
        'district_id' => $localLevelAdminDto->district_id,
        'local_body_id' => $localLevelAdminDto->local_body_id,
        'mobile_no' => $localLevelAdminDto->mobile_no,
        'email' => $localLevelAdminDto->email,
        'website' => $localLevelAdminDto->website,
        'position' => $localLevelAdminDto->position,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LocalLevel $localLevel){
    return tap($localLevel)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LocalLevel::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


