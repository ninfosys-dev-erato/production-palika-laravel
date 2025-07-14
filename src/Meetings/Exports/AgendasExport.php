<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\Agenda;

class AgendasExport implements FromCollection
{
    public $agendas;

    public function __construct($agendas) {
        $this->agendas = $agendas;
    }

    public function collection()
    {
        return Agenda::select([
'meeting_id',
'proposal',
'description',
'is_final'
])
        ->whereIn('id', $this->agendas)->get();
    }
}