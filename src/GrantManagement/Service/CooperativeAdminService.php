<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\CooperativeAdminDto;
use Src\GrantManagement\Models\Cooperative;

class CooperativeAdminService
{
public function store(CooperativeAdminDto $cooperativeAdminDto){
    
    return Cooperative::create([
        'unique_id' => $cooperativeAdminDto->unique_id,
        'name' => $cooperativeAdminDto->name,
        'cooperative_type_id' => $cooperativeAdminDto->cooperative_type_id,
        'registration_no' => $cooperativeAdminDto->registration_no,
        'registration_date' => $cooperativeAdminDto->registration_date,
        'vat_pan' => $cooperativeAdminDto->vat_pan,
        'objective' => $cooperativeAdminDto->objective,
        // 'affiliation_id' => $cooperativeAdminDto->affiliation_id,
        'province_id' => $cooperativeAdminDto->province_id,
        'district_id' => $cooperativeAdminDto->district_id,
        'local_body_id' => $cooperativeAdminDto->local_body_id,
        'ward_no' => $cooperativeAdminDto->ward_no,
        'village' => $cooperativeAdminDto->village,
        'tole' => $cooperativeAdminDto->tole,
        // 'farmer_id' => $cooperativeAdminDto->farmer_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Cooperative $cooperative, CooperativeAdminDto $cooperativeAdminDto){
    return tap($cooperative)->update([
        'unique_id' => $cooperativeAdminDto->unique_id,
        'name' => $cooperativeAdminDto->name,
        'cooperative_type_id' => $cooperativeAdminDto->cooperative_type_id,
        'registration_no' => $cooperativeAdminDto->registration_no,
        'registration_date' => $cooperativeAdminDto->registration_date,
        'vat_pan' => $cooperativeAdminDto->vat_pan,
        'objective' => $cooperativeAdminDto->objective,
        // 'affiliation_id' => $cooperativeAdminDto->affiliation_id,
        'province_id' => $cooperativeAdminDto->province_id,
        'district_id' => $cooperativeAdminDto->district_id,
        'local_body_id' => $cooperativeAdminDto->local_body_id,
        'ward_no' => $cooperativeAdminDto->ward_no,
        'village' => $cooperativeAdminDto->village,
        'tole' => $cooperativeAdminDto->tole,
        // 'farmer_id' => $cooperativeAdminDto->farmer_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Cooperative $cooperative){
    return tap($cooperative)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Cooperative::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


