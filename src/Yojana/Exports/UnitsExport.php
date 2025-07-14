<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Unit;

class UnitsExport implements FromCollection
{
    public $units;

    public function __construct($units) {
        $this->units = $units;
    }

    public function collection()
    {
        return Unit::select([
'type_id',
'measurement_unit_id',
'title',
'position',
'is_smallest'
])
        ->whereIn('id', $this->units)->get();
    }
}


