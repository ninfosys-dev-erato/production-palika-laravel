<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\CargoHandling;

class CargoHandlingAdminDto
{
   public function __construct(
        public string $fiscal_year_id,
        public string $unit_id,
        public string $material_id
    ){}

public static function fromLiveWireModel(CargoHandling $cargoHandling):CargoHandlingAdminDto{
    return new self(
        fiscal_year_id: $cargoHandling->fiscal_year_id,
        unit_id: $cargoHandling->unit_id,
        material_id: $cargoHandling->material_id
    );
}
}
