<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\DisputeDeadline;

class DisputeDeadlinesExport implements FromCollection
{
    public $dispute_deadlines;

    public function __construct($dispute_deadlines) {
        $this->dispute_deadlines = $dispute_deadlines;
    }

    public function collection()
    {
        return DisputeDeadline::select([
'complaint_registration_id',
'registrar_id',
'deadline_set_date',
'deadline_extension_period'
])
        ->whereIn('id', $this->dispute_deadlines)->get();
    }
}


