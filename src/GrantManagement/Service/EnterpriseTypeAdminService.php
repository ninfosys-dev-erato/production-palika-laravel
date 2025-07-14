<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\EnterpriseTypeAdminDto;
use Src\GrantManagement\Models\EnterpriseType;

class EnterpriseTypeAdminService
{
public function store(EnterpriseTypeAdminDto $enterpriseTypeAdminDto){
    return EnterpriseType::create([
        'title' => $enterpriseTypeAdminDto->title,
        'title_en' => $enterpriseTypeAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(EnterpriseType $enterpriseType, EnterpriseTypeAdminDto $enterpriseTypeAdminDto){
    return tap($enterpriseType)->update([
        'title' => $enterpriseTypeAdminDto->title,
        'title_en' => $enterpriseTypeAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(EnterpriseType $enterpriseType){
    return tap($enterpriseType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    EnterpriseType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


