<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProcessIndicator;

class ProcessIndicatorsExport implements FromCollection
{
    public $process_indicators;

    public function __construct($process_indicators) {
        $this->process_indicators = $process_indicators;
    }

    public function collection()
    {
        return ProcessIndicator::select([
'title',
'unit_id',
'code'
])
        ->whereIn('id', $this->process_indicators)->get();
    }
}


