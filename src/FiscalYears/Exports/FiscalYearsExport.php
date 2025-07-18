<?php

namespace Src\FiscalYears\Exports;

use Illuminate\Support\Collection;
use LaravelIdea\Helper\Src\FiscalYears\Models\_IH_FiscalYear_C;
use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FiscalYears\Models\FiscalYear;

class FiscalYearsExport implements FromCollection
{
    public $fiscal_years;

    public function __construct($fiscal_years)
    {
        $this->fiscal_years = $fiscal_years;
    }

    public function collection(): array|Collection|_IH_FiscalYear_C
    {
        return FiscalYear::select([
            'year'
        ])
            ->whereIn('id', $this->fiscal_years)->get();
    }
}


