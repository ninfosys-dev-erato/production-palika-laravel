<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\EnterpriseAdminDto;
use Src\GrantManagement\Models\Enterprise;

class EnterpriseAdminService
{
public function store(EnterpriseAdminDto $enterpriseAdminDto){
    return Enterprise::create([
        'unique_id' => $enterpriseAdminDto->unique_id,
        'enterprise_type_id' => $enterpriseAdminDto->enterprise_type_id,
        'name' => $enterpriseAdminDto->name,
        'vat_pan' => $enterpriseAdminDto->vat_pan,
        'province_id' => $enterpriseAdminDto->province_id,
        'district_id' => $enterpriseAdminDto->district_id,
        'local_body_id' => $enterpriseAdminDto->local_body_id,
        'ward_no' => $enterpriseAdminDto->ward_no,
        'village' => $enterpriseAdminDto->village,
        'tole' => $enterpriseAdminDto->tole,
        'user_id' => $enterpriseAdminDto->user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Enterprise $enterprise, EnterpriseAdminDto $enterpriseAdminDto){
    return tap($enterprise)->update([
        'unique_id' => $enterpriseAdminDto->unique_id,
        'enterprise_type_id' => $enterpriseAdminDto->enterprise_type_id,
        'name' => $enterpriseAdminDto->name,
        'vat_pan' => $enterpriseAdminDto->vat_pan,
        'province_id' => $enterpriseAdminDto->province_id,
        'district_id' => $enterpriseAdminDto->district_id,
        'local_body_id' => $enterpriseAdminDto->local_body_id,
        'ward_no' => $enterpriseAdminDto->ward_no,
        'village' => $enterpriseAdminDto->village,
        'tole' => $enterpriseAdminDto->tole,
        'user_id' => $enterpriseAdminDto->user_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Enterprise $enterprise){
    return tap($enterprise)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Enterprise::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


