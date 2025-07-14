<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\LocalLevel;

class LocalLevelsExport implements FromCollection
{
    public $local_levels;

    public function __construct($local_levels) {
        $this->local_levels = $local_levels;
    }

    public function collection()
    {
        return LocalLevel::select([
'title',
'short_title',
'type',
'province_id',
'district_id',
'local_body_id',
'mobile_no',
'email',
'website',
'position'
])
        ->whereIn('id', $this->local_levels)->get();
    }
}


