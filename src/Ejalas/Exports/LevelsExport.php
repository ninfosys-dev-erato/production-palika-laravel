<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\Level;

class LevelsExport implements FromCollection
{
    public $levels;

    public function __construct($levels) {
        $this->levels = $levels;
    }

    public function collection()
    {
        return Level::select([
'title',
'title_en'
])
        ->whereIn('id', $this->levels)->get();
    }
}


