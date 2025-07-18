<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\Road;

class RoadsExport implements FromCollection
{
    public $roads;

    public function __construct($roads) {
        $this->roads = $roads;
    }

    public function collection()
    {
        return Road::select([
'map_apply_id',
'direction',
'width',
'dist_from_middle',
'min_dist_from_middle',
'dist_from_side',
'min_dist_from_side',
'dist_from_right',
'min_dist_from_right',
'setback',
'min_setback'
])
        ->whereIn('id', $this->roads)->get();
    }
}


