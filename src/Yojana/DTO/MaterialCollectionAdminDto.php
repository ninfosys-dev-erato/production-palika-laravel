<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\MaterialCollection;

class MaterialCollectionAdminDto
{
   public function __construct(
        public string $material_rate_id,
        public string $unit_id,
        public string $activity_no,
        public string $remarks,
        public string $fiscal_year_id
    ){}

public static function fromLiveWireModel(MaterialCollection $materialCollection):MaterialCollectionAdminDto{
    return new self(
        material_rate_id: $materialCollection->material_rate_id,
        unit_id: $materialCollection->unit_id,
        activity_no: $materialCollection->activity_no,
        remarks: $materialCollection->remarks,
        fiscal_year_id: $materialCollection->fiscal_year_id
    );
}
}
