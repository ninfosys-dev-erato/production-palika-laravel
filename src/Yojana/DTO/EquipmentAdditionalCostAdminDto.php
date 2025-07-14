<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\EquipmentAdditionalCost;

class EquipmentAdditionalCostAdminDto
{
   public function __construct(
        public string $equipment_id,
        public string $fiscal_year_id,
        public string $unit_id,
        public string $rate
    ){}

public static function fromLiveWireModel(EquipmentAdditionalCost $equipmentAdditionalCost):EquipmentAdditionalCostAdminDto{
    return new self(
        equipment_id: $equipmentAdditionalCost->equipment_id,
        fiscal_year_id: $equipmentAdditionalCost->fiscal_year_id,
        unit_id: $equipmentAdditionalCost->unit_id,
        rate: $equipmentAdditionalCost->rate
    );
}
}
