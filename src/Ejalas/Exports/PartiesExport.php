<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\Party;

class PartiesExport implements FromCollection
{
    public $parties;

    public function __construct($parties) {
        $this->parties = $parties;
    }

    public function collection()
    {
        return Party::select([
'name',
'age',
'phone_no',
'citizenship_no',
'gender',
'grandfather_name',
'father_name',
'spouse_name',
'permanent_province_id',
'permanent_district_id',
'permanent_local_body_id',
'permanent_ward_id',
'permanent_tole',
'temporary_province_id',
'temporary_district_id',
'temporary_local_body_id',
'temporary_ward_id',
'temporary_tole'
])
        ->whereIn('id', $this->parties)->get();
    }
}


