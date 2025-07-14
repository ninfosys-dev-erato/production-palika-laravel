<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\JudicialEmployee;

class JudicialEmployeesExport implements FromCollection
{
    public $judicial_employees;

    public function __construct($judicial_employees) {
        $this->judicial_employees = $judicial_employees;
    }

    public function collection()
    {
        return JudicialEmployee::select([
'name',
'local_level_id',
'ward_id',
'level_id',
'designation_id',
'join_date',
'phone_no',
'email'
])
        ->whereIn('id', $this->judicial_employees)->get();
    }
}


