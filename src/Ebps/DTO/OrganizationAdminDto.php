<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\Organization;

class OrganizationAdminDto
{
   public function __construct(
        public ?string $org_name_ne,
        public ?string $org_name_en,
        public ?string $org_email,
        public ?string $org_contact,
        public ?string $org_registration_no,
        public ?string $org_registration_date,
        public ?string $org_registration_document,
        public ?string $org_pan_no,
        public ?string $org_pan_registration_date,
        public ?string $org_pan_document,
        public ?string $logo,
        public ?string $province_id,
        public ?string $district_id,
        public ?string $local_body_id,
        public ?string $ward,
        public ?string $tole,
        public ?string $local_body_registration_date,
        public ?string $local_body_registration_no,
        public ?string $company_registration_document,
        public ?string $is_active,
        public ?string $is_organization,
        public ?string $can_work,
        public ?string $status,
        public ?string $comment
    ){}

public static function fromLiveWireModel(Organization $organization):OrganizationAdminDto{
    return new self(
        org_name_ne: $organization->org_name_ne,
        org_name_en: $organization->org_name_en,
        org_email: $organization->org_email,
        org_contact: $organization->org_contact,
        org_registration_no: $organization->org_registration_no,
        org_registration_date: $organization->org_registration_date,
        org_registration_document: $organization->org_registration_document,
        org_pan_no: $organization->org_pan_no,
        org_pan_registration_date: $organization->org_pan_registration_date,
        org_pan_document: $organization->org_pan_document,
        logo: $organization->logo,
        province_id: $organization->province_id,
        district_id: $organization->district_id,
        local_body_id: $organization->local_body_id,
        ward: $organization->ward,
        tole: $organization->tole,
        local_body_registration_date: $organization->local_body_registration_date,
        local_body_registration_no: $organization->local_body_registration_no,
        company_registration_document: $organization->company_registration_document,
        is_active: $organization->is_active,
        is_organization: $organization->is_organization,
        can_work: $organization->can_work,
        status: $organization->status,
        comment: $organization->comment
    );
}
}
