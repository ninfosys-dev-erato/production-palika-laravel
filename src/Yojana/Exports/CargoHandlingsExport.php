<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\CargoHandling;

class CargoHandlingsExport implements FromCollection
{
    public $cargo_handlings;

    public function __construct($cargo_handlings) {
        $this->cargo_handlings = $cargo_handlings;
    }

    public function collection()
    {
        return CargoHandling::select([
'fiscal_year_id',
'unit_id',
'material_id'
])
        ->whereIn('id', $this->cargo_handlings)->get();
    }
}


