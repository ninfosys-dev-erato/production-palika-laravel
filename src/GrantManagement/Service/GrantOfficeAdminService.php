<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantOfficeAdminDto;
use Src\GrantManagement\Models\GrantOffice;

class GrantOfficeAdminService
{
public function store(GrantOfficeAdminDto $grantOfficeAdminDto){
    return GrantOffice::create([
        'office_name' => $grantOfficeAdminDto->office_name,
        'office_name_en' => $grantOfficeAdminDto->office_name_en,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(GrantOffice $grantOffice, GrantOfficeAdminDto $grantOfficeAdminDto){
    return tap($grantOffice)->update([
        'office_name' => $grantOfficeAdminDto->office_name,
        'office_name_en' => $grantOfficeAdminDto->office_name_en,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(GrantOffice $grantOffice){
    return tap($grantOffice)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    GrantOffice::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


