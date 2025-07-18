<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BudgetSource;

class BudgetSourcesExport implements FromCollection
{
    public $budget_sources;

    public function __construct($budget_sources) {
        $this->budget_sources = $budget_sources;
    }

    public function collection()
    {
        return BudgetSource::select([
'title',
'code',
'level_id'
])
        ->whereIn('id', $this->budget_sources)->get();
    }
}


