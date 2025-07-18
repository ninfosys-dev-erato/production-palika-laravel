<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\ComplaintRegistration;

class ComplaintRegistrationsExport implements FromCollection
{
    public $complaint_registrations;

    public function __construct($complaint_registrations) {
        $this->complaint_registrations = $complaint_registrations;
    }

    public function collection()
    {
        return ComplaintRegistration::select([
'fiscal_year_id',
'reg_no',
'old_reg_no',
'reg_date',
'reg_address',
'complainer_id',
'defender_id',
'priority_id',
'dispute_matter_id',
'subject',
'description',
'claim_request',
'status'
])
        ->whereIn('id', $this->complaint_registrations)->get();
    }
}


