<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BudgetDetail;

class BudgetDetailsExport implements FromCollection
{
    public $budget_details;

    public function __construct($budget_details) {
        $this->budget_details = $budget_details;
    }

    public function collection()
    {
        return BudgetDetail::select([
'ward_id',
'amount'
])
        ->whereIn('id', $this->budget_details)->get();
    }
}


