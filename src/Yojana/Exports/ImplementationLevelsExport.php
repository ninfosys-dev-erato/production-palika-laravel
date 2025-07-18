<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ImplementationLevel;

class ImplementationLevelsExport implements FromCollection
{
    public $implementation_levels;

    public function __construct($implementation_levels) {
        $this->implementation_levels = $implementation_levels;
    }

    public function collection()
    {
        return ImplementationLevel::select([
'title',
'code',
'threshold'
])
        ->whereIn('id', $this->implementation_levels)->get();
    }
}


