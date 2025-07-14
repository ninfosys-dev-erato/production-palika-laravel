<?php

namespace Src\Ebps\Service;

use Frontend\BusinessPortal\Ebps\DTO\OrganizationAdminDto;
use Illuminate\Support\Facades\Auth;
use Src\Ebps\Enums\OrganizationStatusEnum;
use Src\Ebps\Models\Organization;

class OrganizationAdminService
{
public function store(OrganizationAdminDto $organizationAdminDto){
    return Organization::create([
        'org_name_ne' => $organizationAdminDto->org_name_ne,
        'org_name_en' => $organizationAdminDto->org_name_en,
        'org_email' => $organizationAdminDto->org_email,
        'org_contact' => $organizationAdminDto->org_contact,
        'org_registration_no' => $organizationAdminDto->org_registration_no,
        'org_registration_date' => $organizationAdminDto->org_registration_date,
        'org_registration_document' => $organizationAdminDto->org_registration_document,
        'org_pan_no' => $organizationAdminDto->org_pan_no,
        'org_pan_registration_date' => $organizationAdminDto->org_pan_registration_date,
        'org_pan_document' => $organizationAdminDto->org_pan_document,
        'logo' => $organizationAdminDto->logo,
        'province_id' => $organizationAdminDto->province_id,
        'district_id' => $organizationAdminDto->district_id,
        'local_body_id' => $organizationAdminDto->local_body_id,
        'ward' => $organizationAdminDto->ward,
        'tole' => $organizationAdminDto->tole,
        'local_body_registration_date' => $organizationAdminDto->local_body_registration_date,
        'local_body_registration_no' => $organizationAdminDto->local_body_registration_no,
        'company_registration_document' => $organizationAdminDto->company_registration_document,
        'is_active' => $organizationAdminDto->is_active,
        'is_organization' => $organizationAdminDto->is_organization,
        'can_work' => $organizationAdminDto->can_work,
        'status' => OrganizationStatusEnum::PENDING,
        'comment' => $organizationAdminDto->comment,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Organization $organization, OrganizationAdminDto $organizationAdminDto){
    return tap($organization)->update([
        'org_name_ne' => $organizationAdminDto->org_name_ne,
        'org_name_en' => $organizationAdminDto->org_name_en,
        'org_email' => $organizationAdminDto->org_email,
        'org_contact' => $organizationAdminDto->org_contact,
        'org_registration_no' => $organizationAdminDto->org_registration_no,
        'org_registration_date' => $organizationAdminDto->org_registration_date,
        'org_registration_document' => $organizationAdminDto->org_registration_document,
        'org_pan_no' => $organizationAdminDto->org_pan_no,
        'org_pan_registration_date' => $organizationAdminDto->org_pan_registration_date,
        'org_pan_document' => $organizationAdminDto->org_pan_document,
        'logo' => $organizationAdminDto->logo,
        'province_id' => $organizationAdminDto->province_id,
        'district_id' => $organizationAdminDto->district_id,
        'local_body_id' => $organizationAdminDto->local_body_id,
        'ward' => $organizationAdminDto->ward,
        'tole' => $organizationAdminDto->tole,
        'local_body_registration_date' => $organizationAdminDto->local_body_registration_date,
        'local_body_registration_no' => $organizationAdminDto->local_body_registration_no,
        'company_registration_document' => $organizationAdminDto->company_registration_document,
        'is_active' => $organizationAdminDto->is_active,
        'is_organization' => $organizationAdminDto->is_organization,
        'can_work' => $organizationAdminDto->can_work,
        'status' => $organizationAdminDto->status,
        'comment' => $organizationAdminDto->comment,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Organization $organization){
    return tap($organization)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Organization::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


