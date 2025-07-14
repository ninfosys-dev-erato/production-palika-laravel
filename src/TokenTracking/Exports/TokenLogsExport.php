<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TokenTracking\Models\TokenLog;

class TokenLogsExport implements FromCollection
{
    public $token_logs;

    public function __construct($token_logs) {
        $this->token_logs = $token_logs;
    }

    public function collection()
    {
        return TokenLog::select([
'token_id',
'old_status',
'new_status',
'status',
'stage_status',
'old_branch',
'new_branch'
])
        ->whereIn('id', $this->token_logs)->get();
    }
}


