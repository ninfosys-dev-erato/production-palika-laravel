<?php

namespace Src\Provinces\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Provinces\Models\Province;

class ProvincesExport implements FromCollection
{
    public $provinces;

    public function __construct($provinces) {
        $this->provinces = $provinces;
    }

    public function collection()
    {
        return Province::select([
'title',
'title_en'
])
        ->whereIn('id', $this->provinces)->get();
    }
}


