<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\OrganizationDetail;

class OrganizationDetailDto
{
    public function __construct(
        public ?int $parent_id,
        public ?int $map_apply_id,
        public ?int $organization_id,
        public ?string $name,
        public ?string $contact_no,
        public ?string $email,
        public ?string $reason_of_organization_change,
        public ?string $registration_date,
        public ?string $status,
    ) {}

    public static function fromLiveWireModel(OrganizationDetail $organizationDetail): OrganizationDetailDto
    {
        return new self(
            parent_id: $organizationDetail->parent_id,
            map_apply_id: $organizationDetail->map_apply_id,
            organization_id: $organizationDetail->organization_id,
            name: $organizationDetail->name,
            contact_no: $organizationDetail->contact_no,
            email: $organizationDetail->email,
            reason_of_organization_change: $organizationDetail->reason_of_organization_change,
            registration_date: $organizationDetail->registration_date,
            status: $organizationDetail->status
        );
    }
}
