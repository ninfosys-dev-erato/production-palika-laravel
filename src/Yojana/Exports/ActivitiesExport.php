<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Activity;

class ActivitiesExport implements FromCollection
{
    public $activities;

    public function __construct($activities) {
        $this->activities = $activities;
    }

    public function collection()
    {
        return Activity::select([
'title',
'group_id',
'code',
'ref_code',
'unit_id',
'qty_for',
'will_be_in_use'
])
        ->whereIn('id', $this->activities)->get();
    }
}


