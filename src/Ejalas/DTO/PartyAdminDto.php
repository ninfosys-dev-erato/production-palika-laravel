<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\Party;

class PartyAdminDto
{
    public function __construct(
        public string $name,
        public string $age,
        public ?string $phone_no,
        public ?string $citizenship_no,
        public ?string $gender,
        public ?string $grandfather_name,
        public ?string $father_name,
        public ?string $spouse_name,
        public ?string $permanent_province_id,
        public ?string $permanent_district_id,
        public ?string $permanent_local_body_id,
        public ?string $permanent_ward_id,
        public ?string $permanent_tole,
        public ?string $temporary_province_id,
        public ?string $temporary_district_id,
        public ?string $temporary_local_body_id,
        public ?string $temporary_ward_id,
        public ?string $temporary_tole,
    ) {}

    public static function fromLiveWireModel(Party $party): PartyAdminDto
    {
        return new self(
            name: $party->name,
            age: $party->age,
            phone_no: $party->phone_no,
            citizenship_no: $party->citizenship_no,
            gender: $party->gender,
            grandfather_name: $party->grandfather_name,
            father_name: $party->father_name,
            spouse_name: $party->spouse_name,
            permanent_province_id: $party->permanent_province_id,
            permanent_district_id: $party->permanent_district_id,
            permanent_local_body_id: $party->permanent_local_body_id,
            permanent_ward_id: $party->permanent_ward_id,
            permanent_tole: $party->permanent_tole,
            temporary_province_id: $party->temporary_province_id,
            temporary_district_id: $party->temporary_district_id,
            temporary_local_body_id: $party->temporary_local_body_id,
            temporary_ward_id: $party->temporary_ward_id,
            temporary_tole: $party->temporary_tole,
        );
    }
}
