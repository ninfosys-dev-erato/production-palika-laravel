<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\LabourRate;

class LabourRatesExport implements FromCollection
{
    public $labour_rates;

    public function __construct($labour_rates) {
        $this->labour_rates = $labour_rates;
    }

    public function collection()
    {
        return LabourRate::select([
'fiscal_year_id',
'labour_id',
'rate'
])
        ->whereIn('id', $this->labour_rates)->get();
    }
}


