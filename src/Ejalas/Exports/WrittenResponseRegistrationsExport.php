<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\WrittenResponseRegistration;

class WrittenResponseRegistrationsExport implements FromCollection
{
    public $written_response_registrations;

    public function __construct($written_response_registrations) {
        $this->written_response_registrations = $written_response_registrations;
    }

    public function collection()
    {
        return WrittenResponseRegistration::select([
'response_registration_no',
'complaint_registration_id',
'registration_date',
'fee_amount',
'fee_receipt_no',
'fee_paid_date',
'description',
'claim_request',
'submitted_within_deadline',
'fee_receipt_attached',
'status'
])
        ->whereIn('id', $this->written_response_registrations)->get();
    }
}


