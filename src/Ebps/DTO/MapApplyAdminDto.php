<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\MapApply;

class MapApplyAdminDto
{
   public function __construct(
        public ?string $submission_id,
        public ?string $registration_date,
        public ?string $registration_no,
        public null|int|string $fiscal_year_id,
        public ?string $customer_id,
        public ?string $land_detail_id,
        public ?string $construction_type_id,
        public ?string $usage,
        public ?bool $is_applied_by_customer,
        public ?string $full_name,
        public ?string $age,
        public ?string $applied_date,
        public ?string $signature,
        public ?string $map_process_type,
        public ?string $building_structure,
        public ?string $house_owner_id,
        public ?string $land_owner_id,
        public ?string $application_type,
        public ?string $area_of_building_plinth,
        public ?string $applicant_type,
        public int|string|null $storey_no,
        public int|string|null $no_of_rooms,
        public int|string|null $year_of_house_built,
        public ?string $mobile_no,
        public ?string $province_id,
        public ?string $district_id,
        public ?string $local_body_id,
        public ?string $ward_no,
        public ?string $ownership_type,
    ){}

public static function fromLiveWireModel(MapApply $mapApply):MapApplyAdminDto{
    return new self(
        submission_id: $mapApply->submission_id,
        registration_date: $mapApply->registration_date ?? null,
        registration_no: $mapApply->registration_no ?? null,
        fiscal_year_id: $mapApply->fiscal_year_id ?? key(getSettingWithKey('fiscal-year')),
        customer_id: $mapApply->customer_id,
        land_detail_id: $mapApply->land_detail_id ?? null,
        construction_type_id: $mapApply->construction_type_id,
        usage: $mapApply->usage ?? null,
        is_applied_by_customer: $mapApply->is_applied_by_customer ?? false,
        full_name: $mapApply->full_name ?? null,
        age: $mapApply->age ?? null,
        applied_date: $mapApply->applied_date ?? null,
        signature: $mapApply->signature ?? null,
        map_process_type:  $mapApply->map_process_type ?? null,
        building_structure:  $mapApply->building_structure ?? null,  
        house_owner_id: $mapApply->house_owner_id ?? null,
        land_owner_id: $mapApply->land_owner_id ?? null,
        area_of_building_plinth: $mapApply->area_of_building_plinth ?? null,
        applicant_type:$mapApply->applicant_type ?? null,
        storey_no:$mapApply->storey_no ?? null,
        year_of_house_built:$mapApply->year_of_house_built ?? null,
        mobile_no:$mapApply->mobile_no ?? null,
        province_id:$mapApply->province_id ?? null,
        district_id:$mapApply->district_id ?? null,
        local_body_id:$mapApply->local_body_id ?? null,
        ward_no:$mapApply->ward_no ?? null,
        application_type: $mapApply->application_type ?? null,
        no_of_rooms: $mapApply->no_of_rooms ?? null,
        ownership_type: $mapApply->ownership_type ?? null

    );


   

}
}
