<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\CooperativeTypeAdminDto;
use Src\GrantManagement\Models\CooperativeType;

class CooperativeTypeAdminService
{
public function store(CooperativeTypeAdminDto $cooperativeTypeAdminDto){
    return CooperativeType::create([
        'title' => $cooperativeTypeAdminDto->title,
        'title_en' => $cooperativeTypeAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CooperativeType $cooperativeType, CooperativeTypeAdminDto $cooperativeTypeAdminDto){
    return tap($cooperativeType)->update([
        'title' => $cooperativeTypeAdminDto->title,
        'title_en' => $cooperativeTypeAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CooperativeType $cooperativeType){
    return tap($cooperativeType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CooperativeType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


