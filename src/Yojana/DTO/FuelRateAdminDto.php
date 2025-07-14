<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\FuelRate;

class FuelRateAdminDto
{
   public function __construct(
        public string $fuel_id,
        public string $rate,
        public string $has_included_vat
    ){}

public static function fromLiveWireModel(FuelRate $fuelRate):FuelRateAdminDto{
    return new self(
        fuel_id: $fuelRate->fuel_id,
        rate: $fuelRate->rate,
        has_included_vat: $fuelRate->has_included_vat
    );
}
}
