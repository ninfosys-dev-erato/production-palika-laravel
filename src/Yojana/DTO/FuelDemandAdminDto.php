<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\FuelDemand;

class FuelDemandAdminDto
{
   public function __construct(
        public string $fuel_id,
        public string $equipment_id,
        public string $quantity
    ){}

public static function fromLiveWireModel(FuelDemand $fuelDemand):FuelDemandAdminDto{
    return new self(
        fuel_id: $fuelDemand->fuel_id,
        equipment_id: $fuelDemand->equipment_id,
        quantity: $fuelDemand->quantity
    );
}
}
