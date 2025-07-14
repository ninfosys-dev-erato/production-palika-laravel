<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\Storey;

class StoreysExport implements FromCollection
{
    public $storeys;

    public function __construct($storeys) {
        $this->storeys = $storeys;
    }

    public function collection()
    {
        return Storey::select([
'title'
])
        ->whereIn('id', $this->storeys)->get();
    }
}


