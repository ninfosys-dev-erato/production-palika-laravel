<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\RegisterTokens\Models\RegisterToken;

class RegisterTokensExport implements FromCollection
{
    public $register_tokens;

    public function __construct($register_tokens) {
        $this->register_tokens = $register_tokens;
    }

    public function collection()
    {
        return RegisterToken::select([
'token',
'token_purpose',
'fiscal_year',
'status',
'date',
'date_en',
'branches',
'current_branch',
'stage',
'entry_time',
'exit_time',
'estimated_time'
])
        ->whereIn('id', $this->register_tokens)->get();
    }
}


