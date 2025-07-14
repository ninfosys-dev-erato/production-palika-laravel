<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\OrganizationUserAdminDto;
use Src\Ebps\Models\OrganizationUser;

class OrganizationUserAdminService
{
public function store(OrganizationUserAdminDto $organizationUserAdminDto){
    return OrganizationUser::create([
        'name' => $organizationUserAdminDto->name,
        'email' => $organizationUserAdminDto->email,
        'photo' => $organizationUserAdminDto->photo,
        'phone' => $organizationUserAdminDto->phone,
        'password' => $organizationUserAdminDto->password,
        'is_active' => $organizationUserAdminDto->is_active,
        'is_organization' => $organizationUserAdminDto->is_organization,
        'organizations_id' => $organizationUserAdminDto->organizations_id,
        'can_work' => $organizationUserAdminDto->can_work,
        'status' => $organizationUserAdminDto->status,
        'comment' => $organizationUserAdminDto->comment,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(OrganizationUser $organizationUser, OrganizationUserAdminDto $organizationUserAdminDto){
    return tap($organizationUser)->update([
        'name' => $organizationUserAdminDto->name,
        'email' => $organizationUserAdminDto->email,
        'photo' => $organizationUserAdminDto->photo,
        'phone' => $organizationUserAdminDto->phone,
        'password' => $organizationUserAdminDto->password,
        'is_active' => $organizationUserAdminDto->is_active,
        'is_organization' => $organizationUserAdminDto->is_organization,
        'organizations_id' => $organizationUserAdminDto->organizations_id,
        'can_work' => $organizationUserAdminDto->can_work,
        'status' => $organizationUserAdminDto->status,
        'comment' => $organizationUserAdminDto->comment,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(OrganizationUser $organizationUser){
    return tap($organizationUser)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    OrganizationUser::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


