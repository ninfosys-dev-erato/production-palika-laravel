<?php

namespace Frontend\CustomerPortal\Ebps\DTO;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Models\CustomerLandDetail;

class CustomerLandDetailDto
{
    public function __construct(
        public ?string $customer_id,
        public ?int $local_body_id,
        public ?int $ward,
        public ?string $tole,
        public int|string|null $area_sqm,
        public ?int $lot_no,
        public ?int $seat_no,
        public ?string $ownership,
        public ?bool $is_landlord
    ) {}

    public static function fromLiveWireModel(CustomerLandDetail $customerLandDetai): CustomerLandDetailDto
    {
        return new self(
            customer_id: $customerLandDetai->customer_id ?? null,
            local_body_id: $customerLandDetai->local_body_id,
            ward: $customerLandDetai->ward,
            tole: $customerLandDetai->tole,
            area_sqm: $customerLandDetai->area_sqm,
            lot_no: $customerLandDetai->lot_no,
            seat_no: $customerLandDetai->seat_no,
            ownership: $customerLandDetai->ownership,
            is_landlord: $customerLandDetai->is_landlord ?? false
        );
    }
}
