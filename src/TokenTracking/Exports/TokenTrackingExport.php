<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TokenTracking\Models\RegisterTokenLog;

class TokenTrackingExport implements FromCollection
{
    public $register_token_logs;

    public function __construct($register_token_logs) {
        $this->register_token_logs = $register_token_logs;
    }

    public function collection()
    {
        return RegisterTokenLog::select([
'token_id',
'old_branch',
'current_branch',
'old_stage',
'current_stage',
'old_status',
'current_status',
'old_values',
'current_values',
'description'
])
        ->whereIn('id', $this->register_token_logs)->get();
    }
}


