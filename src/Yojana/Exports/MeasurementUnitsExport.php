<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\MeasurementUnit;

class MeasurementUnitsExport implements FromCollection
{
    public $measurement_units;

    public function __construct($measurement_units) {
        $this->measurement_units = $measurement_units;
    }

    public function collection()
    {
        return MeasurementUnit::select([
'type_id',
'title'
])
        ->whereIn('id', $this->measurement_units)->get();
    }
}


