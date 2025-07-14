<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Target;

class TargetsExport implements FromCollection
{
    public $targets;

    public function __construct($targets) {
        $this->targets = $targets;
    }

    public function collection()
    {
        return Target::select([
'title',
'code'
])
        ->whereIn('id', $this->targets)->get();
    }
}


