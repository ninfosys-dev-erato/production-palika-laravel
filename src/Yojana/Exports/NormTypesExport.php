<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\NormType;

class NormTypesExport implements FromCollection
{
    public $norm_types;

    public function __construct($norm_types) {
        $this->norm_types = $norm_types;
    }

    public function collection()
    {
        return NormType::select([
'title',
'authority_name',
'year'
])
        ->whereIn('id', $this->norm_types)->get();
    }
}


