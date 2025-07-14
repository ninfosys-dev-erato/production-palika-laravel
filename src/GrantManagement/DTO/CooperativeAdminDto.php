<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Cooperative;

class CooperativeAdminDto
{
   public function __construct(
        public ?string $unique_id,
        public ?string $name,
        public ?string $cooperative_type_id,
        public ?string $registration_no,
        public ?string $registration_date,
        public ?string $vat_pan,
        public ?string $objective,
        public ?string $province_id,
        public ?string $district_id,
        public ?string $local_body_id,
        public ?string $ward_no,
        public ?string $village,
        public ?string $tole,
        
    ){}

public static function fromLiveWireModel(Cooperative $cooperative):CooperativeAdminDto{
    return new self(
        unique_id: $cooperative->unique_id,
        name: $cooperative->name,
        cooperative_type_id: $cooperative->cooperative_type_id,
        registration_no: $cooperative->registration_no,
        registration_date: $cooperative->registration_date,
        vat_pan: $cooperative->vat_pan,
        objective: $cooperative->objective,
        province_id: $cooperative->province_id,
        district_id: $cooperative->district_id,
        local_body_id: $cooperative->local_body_id,
        ward_no: $cooperative->ward_no,
        village: $cooperative->village,
        tole: $cooperative->tole,
    );
}
}
