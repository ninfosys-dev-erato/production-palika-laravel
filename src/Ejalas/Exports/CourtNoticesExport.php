<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\CourtNotice;

class CourtNoticesExport implements FromCollection
{
    public $court_notices;

    public function __construct($court_notices) {
        $this->court_notices = $court_notices;
    }

    public function collection()
    {
        return CourtNotice::select([
'notice_no',
'fiscal_year_id',
'complaint_registration_id',
'reference_no',
'notice_date',
'notice_time',
'reconciliation_center_id'
])
        ->whereIn('id', $this->court_notices)->get();
    }
}


