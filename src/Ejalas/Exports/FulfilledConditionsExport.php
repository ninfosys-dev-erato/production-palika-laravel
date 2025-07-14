<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\FulfilledCondition;

class FulfilledConditionsExport implements FromCollection
{
    public $fulfilled_conditions;

    public function __construct($fulfilled_conditions) {
        $this->fulfilled_conditions = $fulfilled_conditions;
    }

    public function collection()
    {
        return FulfilledCondition::select([
'complaint_registration_id',
'fulfilling_party',
'condition',
'completion_details',
'completion_proof',
'due_date',
'completion_date',
'entered_by',
'entry_date'
])
        ->whereIn('id', $this->fulfilled_conditions)->get();
    }
}


