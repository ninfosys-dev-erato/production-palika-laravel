<?php

namespace Src\FuelSettings\DTO;

use Src\FuelSettings\Models\FuelSetting;

class FuelSettingAdminDto
{
   public function __construct(
        public string $acceptor_id,
        public string $reviewer_id,
        public string $expiry_days,
        public string $ward_no
    ){}

public static function fromLiveWireModel(FuelSetting $fuelSetting):FuelSettingAdminDto{
    return new self(
        acceptor_id: $fuelSetting->acceptor_id,
        reviewer_id: $fuelSetting->reviewer_id,
        expiry_days: $fuelSetting->expiry_days,
        ward_no: $fuelSetting->ward_no
    );
}
}
