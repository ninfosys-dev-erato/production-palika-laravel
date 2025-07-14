<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\FourBoundary;

class FourBoundariesExport implements FromCollection
{
    public $four_boundaries;

    public function __construct($four_boundaries) {
        $this->four_boundaries = $four_boundaries;
    }

    public function collection()
    {
        return FourBoundary::select([
'land_detail_id',
'title',
'direction',
'distance',
'lot_no'
])
        ->whereIn('id', $this->four_boundaries)->get();
    }
}


