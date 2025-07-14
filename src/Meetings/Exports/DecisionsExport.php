<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\Decision;

class DecisionsExport implements FromCollection
{
    public $decisions;

    public function __construct($decisions) {
        $this->decisions = $decisions;
    }

    public function collection()
    {
        return Decision::select([
'meeting_id',
'date',
'chairman',
'en_date',
'description',
'user_id'
])
        ->whereIn('id', $this->decisions)->get();
    }
}