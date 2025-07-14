<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\HelplessnessTypeAdminDto;
use Src\GrantManagement\Models\HelplessnessType;

class HelplessnessTypeAdminService
{
public function store(HelplessnessTypeAdminDto $helplessnessTypeAdminDto){
    return HelplessnessType::create([
        'helplessness_type' => $helplessnessTypeAdminDto->helplessness_type,
        'helplessness_type_en' => $helplessnessTypeAdminDto->helplessness_type_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(HelplessnessType $helplessnessType, HelplessnessTypeAdminDto $helplessnessTypeAdminDto){
    return tap($helplessnessType)->update([
        'helplessness_type' => $helplessnessTypeAdminDto->helplessness_type,
        'helplessness_type_en' => $helplessnessTypeAdminDto->helplessness_type_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(HelplessnessType $helplessnessType){
    return tap($helplessnessType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    HelplessnessType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


