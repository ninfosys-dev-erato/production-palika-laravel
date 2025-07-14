<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Labour;

class LaboursExport implements FromCollection
{
    public $labours;

    public function __construct($labours) {
        $this->labours = $labours;
    }

    public function collection()
    {
        return Labour::select([
'title',
'unit_id'
])
        ->whereIn('id', $this->labours)->get();
    }
}


