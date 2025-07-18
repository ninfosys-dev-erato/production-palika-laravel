<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Anusuchi;

class AnusuchisExport implements FromCollection
{
    public $anusuchis;

    public function __construct($anusuchis) {
        $this->anusuchis = $anusuchis;
    }

    public function collection()
    {
        return Anusuchi::select([
'name',
'name_en',
'description'
])
        ->whereIn('id', $this->anusuchis)->get();
    }
}


