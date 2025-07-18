<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\StoreyDetail;

class StoreyDetailsExport implements FromCollection
{
    public $storey_details;

    public function __construct($storey_details) {
        $this->storey_details = $storey_details;
    }

    public function collection()
    {
        return StoreyDetail::select([
'map_apply_id',
'storey_id',
'purposed_area',
'former_area',
'height',
'remarks'
])
        ->whereIn('id', $this->storey_details)->get();
    }
}


