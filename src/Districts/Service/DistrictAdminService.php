<?php

namespace Src\Districts\Service;

use Illuminate\Support\Facades\Auth;
use Src\Districts\DTO\DistrictAdminDto;
use Src\Districts\Models\District;

class DistrictAdminService
{
public function store(DistrictAdminDto $districtAdminDto){
    return District::create([
        'province_id' => $districtAdminDto->province_id,
        'title' => $districtAdminDto->title,
        'title_en' => $districtAdminDto->title_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(District $district, DistrictAdminDto $districtAdminDto){
    return tap($district)->update([
        'province_id' => $districtAdminDto->province_id,
        'title' => $districtAdminDto->title,
        'title_en' => $districtAdminDto->title_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(District $district){
    return tap($district)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    District::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


