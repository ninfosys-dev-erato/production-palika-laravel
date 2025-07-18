<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\Settlement;

class SettlementsExport implements FromCollection
{
    public $settlements;

    public function __construct($settlements) {
        $this->settlements = $settlements;
    }

    public function collection()
    {
        return Settlement::select([
'complaint_registration_id',
'discussion_date',
'settlement_date',
'present_members',
'fulfilling_party',
'fulfillment_date',
'term',
'settlement_details',
'is_settled'
])
        ->whereIn('id', $this->settlements)->get();
    }
}


