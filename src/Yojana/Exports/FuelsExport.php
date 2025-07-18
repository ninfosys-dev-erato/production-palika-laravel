<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Fuel;

class FuelsExport implements FromCollection
{
    public $fuels;

    public function __construct($fuels) {
        $this->fuels = $fuels;
    }

    public function collection()
    {
        return Fuel::select([
'title',
'unit_id'
])
        ->whereIn('id', $this->fuels)->get();
    }
}


