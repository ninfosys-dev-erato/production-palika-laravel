<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\AdvancePayment;

class AdvancePaymentsExport implements FromCollection
{
    public $advance_payments;

    public function __construct($advance_payments) {
        $this->advance_payments = $advance_payments;
    }

    public function collection()
    {
        return AdvancePayment::select([
'plan_id',
'installment',
'date',
'clearance_date',
'advance_deposit_number',
'paid_amount'
])
        ->whereIn('id', $this->advance_payments)->get();
    }
}


