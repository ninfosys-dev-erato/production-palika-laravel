<?php

namespace Src\FiscalYears\DTO;

use Src\FiscalYears\Models\FiscalYear;

class FiscalYearAdminDto
{
   public function __construct(
        public string $year
    ){}

    public static function fromLiveWireModel(FiscalYear $fiscalYear):FiscalYearAdminDto{
        return new self(
            year: $fiscalYear->year
        );
    }
}
