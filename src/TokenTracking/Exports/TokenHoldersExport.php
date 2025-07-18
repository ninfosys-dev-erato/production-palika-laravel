<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TokenTracking\Models\TokenHolder;

class TokenHoldersExport implements FromCollection
{
    public $token_holders;

    public function __construct($token_holders) {
        $this->token_holders = $token_holders;
    }

    public function collection()
    {
        return TokenHolder::select([
'name',
'email',
'mobile_no',
'address'
])
        ->whereIn('id', $this->token_holders)->get();
    }
}


