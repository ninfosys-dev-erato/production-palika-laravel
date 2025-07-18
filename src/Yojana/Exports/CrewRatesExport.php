<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\CrewRate;

class CrewRatesExport implements FromCollection
{
    public $crew_rates;

    public function __construct($crew_rates) {
        $this->crew_rates = $crew_rates;
    }

    public function collection()
    {
        return CrewRate::select([
'labour_id',
'equipment_id',
'quantity'
])
        ->whereIn('id', $this->crew_rates)->get();
    }
}


