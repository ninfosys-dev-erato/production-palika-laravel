<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\LabourRate;

class LabourRateAdminDto
{
   public function __construct(
        public string $fiscal_year_id,
        public string $labour_id,
        public string $rate
    ){}

public static function fromLiveWireModel(LabourRate $labourRate):LabourRateAdminDto{
    return new self(
        fiscal_year_id: $labourRate->fiscal_year_id,
        labour_id: $labourRate->labour_id,
        rate: $labourRate->rate
    );
}
}
