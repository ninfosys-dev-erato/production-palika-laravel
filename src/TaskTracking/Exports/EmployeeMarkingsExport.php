<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\EmployeeMarking;

class EmployeeMarkingsExport implements FromCollection
{
    public $employee_markings;

    public function __construct($employee_markings) {
        $this->employee_markings = $employee_markings;
    }

    public function collection()
    {
        return EmployeeMarking::select([
'employee_id',
'anusuchi_id',
'criteria_id',
'score',
'fiscal_year',
'period_title',
'period_type',
'date_from',
'date_to'
])
        ->whereIn('id', $this->employee_markings)->get();
    }
}


