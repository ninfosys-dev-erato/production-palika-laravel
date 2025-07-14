<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\MaterialRate;

class MaterialRatesExport implements FromCollection
{
    public $material_rates;

    public function __construct($material_rates) {
        $this->material_rates = $material_rates;
    }

    public function collection()
    {
        return MaterialRate::select([
'material_id',
'fiscal_year_id',
'is_vat_included',
'is_vat_needed',
'referance_no',
'royalty'
])
        ->whereIn('id', $this->material_rates)->get();
    }
}


