<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\StructureType;

class StructureTypesExport implements FromCollection
{
    public $structure_types;

    public function __construct($structure_types) {
        $this->structure_types = $structure_types;
    }

    public function collection()
    {
        return StructureType::select([
'title'
])
        ->whereIn('id', $this->structure_types)->get();
    }
}


