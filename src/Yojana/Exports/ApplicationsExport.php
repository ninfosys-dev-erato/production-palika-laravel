<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Application;

class ApplicationsExport implements FromCollection
{
    public $applications;

    public function __construct($applications) {
        $this->applications = $applications;
    }

    public function collection()
    {
        return Application::select([
'applicant_name',
'address',
'mobile_number',
'bank_id',
'account_number',
'is_employee'
])
        ->whereIn('id', $this->applications)->get();
    }
}


