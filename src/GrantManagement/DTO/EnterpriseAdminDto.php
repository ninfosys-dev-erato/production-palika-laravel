<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Enterprise;

class EnterpriseAdminDto
{
   public function __construct(
        public ?string $unique_id,
        public string $enterprise_type_id,
        public string $name,
        public string $vat_pan,
        public string $province_id,
        public string $district_id,
        public string $local_body_id,
        public string $ward_no,
        public string $village,
        public string $tole,
        public ?string $user_id,
    ){}

public static function fromLiveWireModel(Enterprise $enterprise):EnterpriseAdminDto{
    return new self(
        unique_id: $enterprise->unique_id,
        enterprise_type_id: $enterprise->enterprise_type_id,
        name: $enterprise->name,
        vat_pan: $enterprise->vat_pan,
        province_id: $enterprise->province_id,
        district_id: $enterprise->district_id,
        local_body_id: $enterprise->local_body_id,
        ward_no: $enterprise->ward_no,
        village: $enterprise->village,
        tole: $enterprise->tole,
        user_id: $enterprise->user_id,
    );
}
}
