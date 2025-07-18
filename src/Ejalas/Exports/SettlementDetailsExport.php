<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\SettlementDetail;

class SettlementDetailsExport implements FromCollection
{
    public $settlement_details;

    public function __construct($settlement_details)
    {
        $this->settlement_details = $settlement_details;
    }

    public function collection()
    {
        return SettlementDetail::select([
            'complaint_registration_id',
            'party_id',
            'deadline_set_date',
            'detail',
            'created_at',
            'updated_at'
        ])
            ->whereIn('id', $this->settlement_details)
            ->get();
    }
}
