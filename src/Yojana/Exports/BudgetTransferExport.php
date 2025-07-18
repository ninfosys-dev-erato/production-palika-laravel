<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\BudgetTransfer;

class BudgetTransferExport implements FromCollection
{
    public $budget_transfer;

    public function __construct($budget_transfer) {
        $this->budget_transfer = $budget_transfer;
    }

    public function collection()
    {
        return BudgetTransfer::select([
            'from_plan',
            'to_plan',
            'date'
        ])
            ->whereIn('id', $this->budget_transfer)->get();    }
}
