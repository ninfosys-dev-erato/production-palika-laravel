<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\JudicialMeeting;

class JudicialMeetingsExport implements FromCollection
{
    public $judicial_meetings;

    public function __construct($judicial_meetings) {
        $this->judicial_meetings = $judicial_meetings;
    }

    public function collection()
    {
        return JudicialMeeting::select([
'fiscal_year_id',
'meeting_date',
'meeting_time',
'meeting_number',
'decision_number',
'invited_employee_id',
'members_present_id',
'meeting_topic',
'decision_details'
])
        ->whereIn('id', $this->judicial_meetings)->get();
    }
}


