<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\MapApply;

class MapAppliesExport implements FromCollection
{
    public $map_applies;

    public function __construct($map_applies) {
        $this->map_applies = $map_applies;
    }

    public function collection()
    {
        return MapApply::select([
'submission_id',
'registration_date',
'registration_no',
'fiscal_year_id',
'customer_id',
'land_detail_id',
'construction_type_id',
'usage',
'is_applied_by_customer',
'full_name',
'age',
'applied_date',
'signature'
])
        ->whereIn('id', $this->map_applies)->get();
    }
}


