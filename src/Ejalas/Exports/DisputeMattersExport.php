<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\DisputeMatter;

class DisputeMattersExport implements FromCollection
{
    public $dispute_matters;

    public function __construct($dispute_matters) {
        $this->dispute_matters = $dispute_matters;
    }

    public function collection()
    {
        return DisputeMatter::select([
'title',
'dispute_area_id'
])
        ->whereIn('id', $this->dispute_matters)->get();
    }
}


