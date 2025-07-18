<?php

namespace Src\Districts\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Districts\Models\District;

class DistrictsExport implements FromCollection
{
    public $districts;

    public function __construct($districts) {
        $this->districts = $districts;
    }

    public function collection()
    {
        return District::select([
'province_id',
'title',
'title_en'
])
        ->whereIn('id', $this->districts)->get();
    }
}


