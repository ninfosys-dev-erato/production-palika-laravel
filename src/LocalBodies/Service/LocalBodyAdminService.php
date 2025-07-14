<?php

namespace Src\LocalBodies\Service;

use Illuminate\Support\Facades\Auth;
use Src\LocalBodies\DTO\LocalBodyAdminDto;
use Src\LocalBodies\Models\LocalBody;

class LocalBodyAdminService
{
public function store(LocalBodyAdminDto $localBodyAdminDto){
    return LocalBody::create([
        'district_id' => $localBodyAdminDto->district_id,
        'title' => $localBodyAdminDto->title,
        'title_en' => $localBodyAdminDto->title_en,
        'wards' => $localBodyAdminDto->wards,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LocalBody $localBody, LocalBodyAdminDto $localBodyAdminDto){
    return tap($localBody)->update([
        'district_id' => $localBodyAdminDto->district_id,
        'title' => $localBodyAdminDto->title,
        'title_en' => $localBodyAdminDto->title_en,
        'wards' => $localBodyAdminDto->wards,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LocalBody $localBody){
    return tap($localBody)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LocalBody::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


