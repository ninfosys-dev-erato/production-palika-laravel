<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Farmer;

class FarmerAdminDto
{
    public function __construct(
        public ?string $unique_id,
        public ?string $first_name,
        public ?string $middle_name,
        public ?string $last_name,
        public ?string $photo,
        public ?string $gender,
        public ?string $marital_status,
        public ?string $spouse_name,
        public ?string $father_name,
        public ?string $grandfather_name,
        public ?string $citizenship_no,
        public ?string $farmer_id_card_no,
        public ?string $national_id_card_no,
        public ?string $phone_no,
        public ?string $province_id,
        public ?string $district_id,
        public ?string $local_body_id,
        public ?string $ward_no,
        public ?string $village,
        public ?string $tole,
        public ?string $user_id,
        public ?string $involved_farmers_ids,
        public ?array $farmer_ids,
        public ?array $relationships

    ) {
    }

    public static function fromLiveWireModel(Farmer $farmer): FarmerAdminDto
    {
        return new self(
            unique_id: $farmer->unique_id,
            first_name: $farmer->first_name,
            middle_name: $farmer->middle_name,
            last_name: $farmer->last_name,
            photo: $farmer->photo,
            gender: $farmer->gender,
            marital_status: $farmer->marital_status,
            spouse_name: $farmer->spouse_name,
            father_name: $farmer->father_name,
            grandfather_name: $farmer->grandfather_name,
            citizenship_no: $farmer->citizenship_no,
            farmer_id_card_no: $farmer->farmer_id_card_no,
            national_id_card_no: $farmer->national_id_card_no,
            phone_no: $farmer->phone_no,
            province_id: $farmer->province_id,
            district_id: $farmer->district_id,
            local_body_id: $farmer->local_body_id,
            ward_no: $farmer->ward_no,
            village: $farmer->village,
            tole: $farmer->tole,
            user_id: $farmer->user_id,
            involved_farmers_ids: $farmer->involved_farmers_ids,
            farmer_ids: $farmer->farmer_ids,
            relationships: $farmer->relationships,
        );
    }
}
