<?php

namespace Src\Wards\DTO;

use Src\Wards\Models\Ward;

class WardAdminDto
{
   public function __construct(
        public int $id,
        public string $local_body_id,
        public string $phone,
        public string $email,
        public string $address_en,
        public string $address_ne,
        public string $ward_name_en,
        public string $ward_name_ne
    ){}

public static function fromLiveWireModel(Ward $ward):WardAdminDto{
    return new self(
        id: $ward->id,
        local_body_id: $ward->local_body_id,
        phone: $ward->phone,
        email: $ward->email,
        address_en: $ward->address_en,
        address_ne: $ward->address_ne,
        ward_name_en: $ward->ward_name_en,
        ward_name_ne: $ward->ward_name_ne
    );
}
}
