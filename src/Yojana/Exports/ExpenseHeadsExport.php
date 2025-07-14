<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ExpenseHead;

class ExpenseHeadsExport implements FromCollection
{
    public $expense_heads;

    public function __construct($expense_heads) {
        $this->expense_heads = $expense_heads;
    }

    public function collection()
    {
        return ExpenseHead::select([
'title'
])
        ->whereIn('id', $this->expense_heads)->get();
    }
}


