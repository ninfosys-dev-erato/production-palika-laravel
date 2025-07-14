<?php

namespace Src\Wards\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Wards\Models\Ward;

class WardsExport implements FromCollection
{
    public $wards;

    public function __construct($wards) {
        $this->wards = $wards;
    }

    public function collection()
    {
        return Ward::select([
            'id',
            'local_body_id',
            'phone',
            'email',
            'address_en',
            'address_ne',
            'ward_name_en',
            'ward_name_ne'
        ])
        ->whereIn('id', $this->wards)->get();
    }
}


