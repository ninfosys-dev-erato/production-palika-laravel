<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\Participant;

class ParticipantsExport implements FromCollection
{
    public $participants;

    public function __construct($participants) {
        $this->participants = $participants;
    }

    public function collection()
    {
        return Participant::select([
'meeting_id',
'committee_member_id',
'name',
'designation',
'phone',
'email'
])
        ->whereIn('id', $this->participants)->get();
    }
}