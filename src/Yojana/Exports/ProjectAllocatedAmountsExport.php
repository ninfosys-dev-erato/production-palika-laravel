<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectAllocatedAmount;

class ProjectAllocatedAmountsExport implements FromCollection
{
    public $project_allocated_amounts;

    public function __construct($project_allocated_amounts) {
        $this->project_allocated_amounts = $project_allocated_amounts;
    }

    public function collection()
    {
        return ProjectAllocatedAmount::select([
'project_id',
'budget_head_id',
'amount'
])
        ->whereIn('id', $this->project_allocated_amounts)->get();
    }
}


