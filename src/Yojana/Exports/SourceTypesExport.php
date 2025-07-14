<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\SourceType;

class SourceTypesExport implements FromCollection
{
    public $source_types;

    public function __construct($source_types) {
        $this->source_types = $source_types;
    }

    public function collection()
    {
        return SourceType::select([
'title',
'code'
])
        ->whereIn('id', $this->source_types)->get();
    }
}


