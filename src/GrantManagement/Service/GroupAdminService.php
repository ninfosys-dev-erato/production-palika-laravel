<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GroupAdminDto;
use Src\GrantManagement\Models\Group;

class GroupAdminService
{
public function store(GroupAdminDto $groupAdminDto){
    return Group::create([
        'unique_id' => $groupAdminDto->unique_id,
        'name' => $groupAdminDto->name,
        'registration_date' => $groupAdminDto->registration_date,
        'registered_office' => $groupAdminDto->registered_office,
        'monthly_meeting' => $groupAdminDto->monthly_meeting,
        'vat_pan' => $groupAdminDto->vat_pan,
        'province_id' => $groupAdminDto->province_id,
        'district_id' => $groupAdminDto->district_id,
        'local_body_id' => $groupAdminDto->local_body_id,
        'ward_no' => $groupAdminDto->ward_no,
        'village' => $groupAdminDto->village,
        'tole' => $groupAdminDto->tole,
        'user_id' => $groupAdminDto->user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Group $group, GroupAdminDto $groupAdminDto){
    return tap($group)->update([
        'unique_id' => $groupAdminDto->unique_id,
        'name' => $groupAdminDto->name,
        'registration_date' => $groupAdminDto->registration_date,
        'registered_office' => $groupAdminDto->registered_office,
        'monthly_meeting' => $groupAdminDto->monthly_meeting,
        'vat_pan' => $groupAdminDto->vat_pan,
        'province_id' => $groupAdminDto->province_id,
        'district_id' => $groupAdminDto->district_id,
        'local_body_id' => $groupAdminDto->local_body_id,
        'ward_no' => $groupAdminDto->ward_no,
        'village' => $groupAdminDto->village,
        'tole' => $groupAdminDto->tole,
        'user_id' => $groupAdminDto->user_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Group $group){
    return tap($group)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Group::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


