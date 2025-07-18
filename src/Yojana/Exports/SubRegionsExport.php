<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\SubRegion;

class SubRegionsExport implements FromCollection
{
    public $sub_regions;

    public function __construct($sub_regions) {
        $this->sub_regions = $sub_regions;
    }

    public function collection()
    {
        return SubRegion::select([
'name',
'code',
'area_id',
'in_use'
])
        ->whereIn('id', $this->sub_regions)->get();
    }
}


