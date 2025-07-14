<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BudgetHead;

class BudgetHeadsExport implements FromCollection
{
    public $budget_heads;

    public function __construct($budget_heads) {
        $this->budget_heads = $budget_heads;
    }

    public function collection()
    {
        return BudgetHead::select([
'budget_head_id',
'title'
])
        ->whereIn('id', $this->budget_heads)->get();
    }
}


