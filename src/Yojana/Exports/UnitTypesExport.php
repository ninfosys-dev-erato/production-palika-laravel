<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\UnitType;

class UnitTypesExport implements FromCollection
{
    public $unit_types;

    public function __construct($unit_types) {
        $this->unit_types = $unit_types;
    }

    public function collection()
    {
        return UnitType::select([
'title',
'title_en',
'display_order',
'will_be_in_use'
])
        ->whereIn('id', $this->unit_types)->get();
    }
}


