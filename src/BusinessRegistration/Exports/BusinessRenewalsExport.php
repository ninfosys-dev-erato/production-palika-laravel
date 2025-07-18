<?php

namespace Src\BusinessRegistration\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\BusinessRegistration\Models\BusinessRenewal;

class BusinessRenewalsExport implements FromCollection
{
    public $business_renewals;

    public function __construct($business_renewals)
    {
        $this->business_renewals = $business_renewals;
    }

    public function collection()
    {
        return BusinessRenewal::select([
            'fiscal_year_id',
            'renewable_type',
            'renewable_id',
            'renew_date',
            'renew_date_en',
            'date_to_be_maintained',
            'date_to_be_maintained_en',
            'renew_amount',
            'penalty_amount',
            'payment_receipt',
            'payment_receipt_date',
            'payment_receipt_date_en',
            'reg_no',
            'registration_no'
        ])
            ->whereIn('id', $this->business_renewals)->get();
    }
}
