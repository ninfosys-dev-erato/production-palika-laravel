<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\CrewRate;

class CrewRateAdminDto
{
   public function __construct(
        public string $labour_id,
        public string $equipment_id,
        public string $quantity
    ){}

public static function fromLiveWireModel(CrewRate $crewRate):CrewRateAdminDto{
    return new self(
        labour_id: $crewRate->labour_id,
        equipment_id: $crewRate->equipment_id,
        quantity: $crewRate->quantity
    );
}
}
