<?php

namespace Src\Provinces\Service;

use Illuminate\Support\Facades\Auth;
use Src\Provinces\DTO\ProvinceAdminDto;
use Src\Provinces\Models\Province;

class ProvinceAdminService
{
public function store(ProvinceAdminDto $provinceAdminDto){
    return Province::create([
        'title' => $provinceAdminDto->title,
        'title_en' => $provinceAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Province $province, ProvinceAdminDto $provinceAdminDto){
    return tap($province)->update([
        'title' => $provinceAdminDto->title,
        'title_en' => $provinceAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Province $province){
    return tap($province)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Province::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


