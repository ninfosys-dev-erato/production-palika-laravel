<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\CustomerLandDetai;

class CustomerLandDetaiAdminDto
{
   public function __construct(
        public string $customer_id,
        public string $local_body_id,
        public string $ward,
        public string $tole,
        public string $area_sqm,
        public string $lot_no,
        public string $seat_no,
        public string $ownership,
        public string $is_landlord
    ){}

public static function fromLiveWireModel(CustomerLandDetai $customerLandDetai):CustomerLandDetaiAdminDto{
    return new self(
        customer_id: $customerLandDetai->customer_id,
        local_body_id: $customerLandDetai->local_body_id,
        ward: $customerLandDetai->ward,
        tole: $customerLandDetai->tole,
        area_sqm: $customerLandDetai->area_sqm,
        lot_no: $customerLandDetai->lot_no,
        seat_no: $customerLandDetai->seat_no,
        ownership: $customerLandDetai->ownership,
        is_landlord: $customerLandDetai->is_landlord
    );
}
}
