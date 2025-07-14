<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\Priotity;

class PriotitiesExport implements FromCollection
{
    public $priotities;

    public function __construct($priotities) {
        $this->priotities = $priotities;
    }

    public function collection()
    {
        return Priotity::select([
'name',
'position'
])
        ->whereIn('id', $this->priotities)->get();
    }
}


