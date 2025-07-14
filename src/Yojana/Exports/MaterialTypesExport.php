<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\MaterialType;

class MaterialTypesExport implements FromCollection
{
    public $material_types;

    public function __construct($material_types) {
        $this->material_types = $material_types;
    }

    public function collection()
    {
        return MaterialType::select([
'title'
])
        ->whereIn('id', $this->material_types)->get();
    }
}


