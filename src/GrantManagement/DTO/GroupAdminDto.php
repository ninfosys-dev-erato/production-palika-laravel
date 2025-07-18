<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Group;

class GroupAdminDto
{
   public function __construct(
        public ?string $unique_id,
        public string $name,
        public string $registration_date,
        public string $registered_office,
        public string $monthly_meeting,
        public string $vat_pan,
        public string $province_id,
        public string $district_id,
        public string $local_body_id,
        public string $ward_no,
        public string $village,
        public string $tole,
        public ?string $user_id
    ){}

public static function fromLiveWireModel(Group $group):GroupAdminDto{
    return new self(
        unique_id: $group->unique_id,
        name: $group->name,
        registration_date: $group->registration_date,
        registered_office: $group->registered_office,
        monthly_meeting: $group->monthly_meeting,
        vat_pan: $group->vat_pan,
        province_id: $group->province_id,
        district_id: $group->district_id,
        local_body_id: $group->local_body_id,
        ward_no: $group->ward_no,
        village: $group->village,
        tole: $group->tole,
        user_id: $group->user_id
    );
}
}
