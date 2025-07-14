<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\FuelRate;

class FuelRatesExport implements FromCollection
{
    public $fuel_rates;

    public function __construct($fuel_rates) {
        $this->fuel_rates = $fuel_rates;
    }

    public function collection()
    {
        return FuelRate::select([
'fuel_id',
'rate',
'has_included_vat'
])
        ->whereIn('id', $this->fuel_rates)->get();
    }
}


