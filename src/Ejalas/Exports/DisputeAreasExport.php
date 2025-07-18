<?php

namespace Src\DisputeAreas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DisputeAreas\Models\DisputeArea;

class DisputeAreasExport implements FromCollection
{
    public $dispute_areas;

    public function __construct($dispute_areas) {
        $this->dispute_areas = $dispute_areas;
    }

    public function collection()
    {
        return DisputeArea::select([
'title',
'title_en'
])
        ->whereIn('id', $this->dispute_areas)->get();
    }
}


