<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\OrganizationTypes;
use Src\Yojana\Models\Organization;

class OrganizationAdminDto
{
    public function __construct(
        public OrganizationTypes $type,
        public string $name,
        public string $address,
        public string $pan_number,
        public string $phone_number,
        public string $bank_name,
        public string $branch,
        public string $account_number,
        public string $representative,
        public string $post,
        public string $representative_address,
        public string $mobile_number
    ) {}

    public static function fromLiveWireModel(Organization $organization): OrganizationAdminDto
    {
        return new self(
            type: $organization->type,
            name: $organization->name,
            address: $organization->address,
            pan_number: $organization->pan_number,
            phone_number: $organization->phone_number,
            bank_name: $organization->bank_name,
            branch: $organization->branch,
            account_number: $organization->account_number,
            representative: $organization->representative,
            post: $organization->post,
            representative_address: $organization->representative_address,
            mobile_number: $organization->mobile_number
        );
    }
}
