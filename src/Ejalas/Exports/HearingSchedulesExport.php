<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\HearingSchedule;

class HearingSchedulesExport implements FromCollection
{
    public $hearing_schedules;

    public function __construct($hearing_schedules) {
        $this->hearing_schedules = $hearing_schedules;
    }

    public function collection()
    {
        return HearingSchedule::select([
'hearing_paper_no',
'fiscal_year_id',
'hearing_date',
'hearing_time',
'reference_no',
'reconciliation_center_id'
])
        ->whereIn('id', $this->hearing_schedules)->get();
    }
}


