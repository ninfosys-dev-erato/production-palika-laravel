<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\TechnicalCostEstimate;

class TechnicalCostEstimatesExport implements FromCollection
{
    public $technical_cost_estimates;

    public function __construct($technical_cost_estimates) {
        $this->technical_cost_estimates = $technical_cost_estimates;
    }

    public function collection()
    {
        return TechnicalCostEstimate::select([
'project_id',
'detail',
'quantity',
'unit_id',
'rate'
])
        ->whereIn('id', $this->technical_cost_estimates)->get();
    }
}


