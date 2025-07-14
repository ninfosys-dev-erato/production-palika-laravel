<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\MaterialRate;

class MaterialRateAdminDto
{
   public function __construct(
        public string $material_id,
        public string $fiscal_year_id,
        public string $is_vat_included,
        public string $is_vat_needed,
        public string $referance_no,
        public string $royalty
    ){}

public static function fromLiveWireModel(MaterialRate $materialRate):MaterialRateAdminDto{
    return new self(
        material_id: $materialRate->material_id,
        fiscal_year_id: $materialRate->fiscal_year_id,
        is_vat_included: $materialRate->is_vat_included,
        is_vat_needed: $materialRate->is_vat_needed,
        referance_no: $materialRate->referance_no,
        royalty: $materialRate->royalty
    );
}
}
