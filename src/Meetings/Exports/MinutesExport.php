<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\Minute;

class MinutesExport implements FromCollection
{
    public $minutes;

    public function __construct($minutes) {
        $this->minutes = $minutes;
    }

    public function collection()
    {
        return Minute::select([
'meeting_id',
'description'
])
        ->whereIn('id', $this->minutes)->get();
    }
}