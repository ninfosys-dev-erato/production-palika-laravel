<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Material;

class MaterialsExport implements FromCollection
{
    public $materials;

    public function __construct($materials) {
        $this->materials = $materials;
    }

    public function collection()
    {
        return Material::select([
'material_type_id',
'unit_id',
'title',
'density'
])
        ->whereIn('id', $this->materials)->get();
    }
}


