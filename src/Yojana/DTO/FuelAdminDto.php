<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Fuel;

class FuelAdminDto
{
   public function __construct(
        public string $title,
        public string $unit_id
    ){}

public static function fromLiveWireModel(Fuel $fuel):FuelAdminDto{
    return new self(
        title: $fuel->title,
        unit_id: $fuel->unit_id
    );
}
}
