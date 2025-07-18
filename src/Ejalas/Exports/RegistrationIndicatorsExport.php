<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\RegistrationIndicator;

class RegistrationIndicatorsExport implements FromCollection
{
    public $registration_indicators;

    public function __construct($registration_indicators) {
        $this->registration_indicators = $registration_indicators;
    }

    public function collection()
    {
        return RegistrationIndicator::select([
'dispute_title',
'indicator_type'
])
        ->whereIn('id', $this->registration_indicators)->get();
    }
}


