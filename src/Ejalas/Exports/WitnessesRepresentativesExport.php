<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\WitnessesRepresentative;

class WitnessesRepresentativesExport implements FromCollection
{
    public $witnesses_representatives;

    public function __construct($witnesses_representatives) {
        $this->witnesses_representatives = $witnesses_representatives;
    }

    public function collection()
    {
        return WitnessesRepresentative::select([
'complaint_registration_id',
'name',
'address',
'is_first_party'
])
        ->whereIn('id', $this->witnesses_representatives)->get();
    }
}


