<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\MediatorSelection;

class MediatorSelectionsExport implements FromCollection
{
    public $mediator_selections;

    public function __construct($mediator_selections) {
        $this->mediator_selections = $mediator_selections;
    }

    public function collection()
    {
        return MediatorSelection::select([
'complaint_registration_id',
'mediator_id',
'mediator_type',
'selection_date'
])
        ->whereIn('id', $this->mediator_selections)->get();
    }
}


