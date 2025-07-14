<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\DisputeRegistrationCourt;

class DisputeRegistrationCourtsExport implements FromCollection
{
    public $dispute_registration_courts;

    public function __construct($dispute_registration_courts) {
        $this->dispute_registration_courts = $dispute_registration_courts;
    }

    public function collection()
    {
        return DisputeRegistrationCourt::select([
'complaint_registration_id',
'registrar_id',
'form_id',
'data',
'status'
])
        ->whereIn('id', $this->dispute_registration_courts)->get();
    }
}


