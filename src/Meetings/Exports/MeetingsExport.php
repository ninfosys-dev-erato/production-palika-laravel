<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\Meeting;

class MeetingsExport implements FromCollection
{
    public $meetings;

    public function __construct($meetings)
    {
        $this->meetings = $meetings;
    }

    public function collection()
    {
        return Meeting::select([
            'fiscal_year_id',
            'committee_id',
            'meeting_id',
            'meeting_name',
            'recurrence',
            'start_date',
            'end_date',
            'recurrence_end_date',
            'description',
            'user_id',
            'is_print'
        ])
            ->whereIn('id', $this->meetings)->get();
    }
}


