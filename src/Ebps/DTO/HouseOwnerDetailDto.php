<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\HouseOwnerDetail;

class HouseOwnerDetailDto
{
    public function __construct(
        public ?string $owner_name,
        public ?string $mobile_no,
        public ?string $father_name,
        public ?string $grandfather_name,
        public ?string $citizenship_no,
        public ?string $citizenship_issued_date,
        public ?string $reason_of_owner_change,
        public null|int|string $citizenship_issued_at,
        public null|int|string $province_id,
        public null|int|string $district_id,
        public null|int|string $local_body_id,
        public ?string $ward_no,
        public ?string $tole,
        public ?string $photo,
        public ?string $ownership_type,
        public ?string $parent_id,
        public ?string $status,
    ) {}

    public static function fromLiveWireModel(HouseOwnerDetail $detail): HouseOwnerDetailDto
    {
        return new self(
            
            owner_name: $detail->owner_name,
            mobile_no: $detail->mobile_no,
            father_name: $detail->father_name,
            grandfather_name: $detail->grandfather_name,
            citizenship_no: $detail->citizenship_no,
            citizenship_issued_date: $detail->citizenship_issued_date,
            citizenship_issued_at: $detail->citizenship_issued_at,
            province_id: $detail->province_id,
            district_id: $detail->district_id,
            local_body_id: $detail->local_body_id,
            ward_no: $detail->ward_no,
            tole: $detail->tole ?? null,
            photo: $detail->photo ?? null,
            ownership_type: $detail->ownership_type ?? null,
            parent_id: $detail->parent_id ?? null,
            reason_of_owner_change: $detail->reason_of_owner_change ?? null,
            status: $detail->status ?? null
        );
    }

    public static function fromArray(array $detail): HouseOwnerDetailDto
{
    return new self(
        owner_name: $detail['owner_name'] ?? null,
        mobile_no: $detail['mobile_no'] ?? null,
        father_name: $detail['father_name'] ?? null,
        grandfather_name: $detail['grandfather_name'] ?? null,
        citizenship_no: $detail['citizenship_no'] ?? null,
        citizenship_issued_date: $detail['citizenship_issued_date'] ?? null,
        citizenship_issued_at: $detail['citizenship_issued_at'] ?? null,
        province_id: $detail['province_id'] ?? null,
        district_id: $detail['district_id'] ?? null,
        local_body_id: $detail['local_body_id'] ?? null,
        ward_no: $detail['ward_no'] ?? null,
        tole: $detail['tole'] ?? null,
        ownership_type: $detail['ownership_type'] ?? null,
        reason_of_owner_change: $detail['reason_of_owner_change'] ?? null,
        photo: $detail['photo'] ?? null,
        parent_id: $detail['parent_id'] ?? null,
        status: $detail['status'] ?? null
        
    );
}

}
