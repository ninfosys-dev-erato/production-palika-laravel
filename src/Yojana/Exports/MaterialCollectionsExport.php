<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\MaterialCollection;

class MaterialCollectionsExport implements FromCollection
{
    public $material_collections;

    public function __construct($material_collections) {
        $this->material_collections = $material_collections;
    }

    public function collection()
    {
        return MaterialCollection::select([
'material_rate_id',
'unit_id',
'activity_no',
'remarks',
'fiscal_year_id'
])
        ->whereIn('id', $this->material_collections)->get();
    }
}


