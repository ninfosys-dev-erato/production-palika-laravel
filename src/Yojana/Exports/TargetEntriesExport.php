<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\TargetEntry;

class TargetEntriesExport implements FromCollection
{
    public $target_entries;

    public function __construct($target_entries) {
        $this->target_entries = $target_entries;
    }

    public function collection()
    {
        return TargetEntry::select([
'progress_indicator_id',
'total_physical_progress',
'total_financial_progress',
'last_year_physical_progress',
'last_year_financial_progress',
'total_physical_goals',
'total_financial_goals',
'first_quarter_physical_progress',
'first_quarter_financial_progress',
'second_quarter_physical_progress',
'second_quarter_financial_progress',
'third_quarter_physical_progress',
'third_quarter_financial_progress',
'plan_id'
])
        ->whereIn('id', $this->target_entries)->get();
    }
}


