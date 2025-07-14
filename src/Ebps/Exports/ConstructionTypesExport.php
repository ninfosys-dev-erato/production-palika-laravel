<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\ConstructionType;

class ConstructionTypesExport implements FromCollection
{
    public $construction_types;

    public function __construct($construction_types) {
        $this->construction_types = $construction_types;
    }

    public function collection()
    {
        return ConstructionType::select([
'title'
])
        ->whereIn('id', $this->construction_types)->get();
    }
}


