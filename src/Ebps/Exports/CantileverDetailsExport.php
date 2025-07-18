<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\CantileverDetail;

class CantileverDetailsExport implements FromCollection
{
    public $cantilever_details;

    public function __construct($cantilever_details) {
        $this->cantilever_details = $cantilever_details;
    }

    public function collection()
    {
        return CantileverDetail::select([
'map_apply_id',
'direction',
'distance',
'minimum'
])
        ->whereIn('id', $this->cantilever_details)->get();
    }
}


