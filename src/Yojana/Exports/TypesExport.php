<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Type;

class TypesExport implements FromCollection
{
    public $types;

    public function __construct($types) {
        $this->types = $types;
    }

    public function collection()
    {
        return Type::select([
'title'
])
        ->whereIn('id', $this->types)->get();
    }
}


