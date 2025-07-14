<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Collateral;

class YojanaExport implements FromCollection
{
    public $collaterals;

    public function __construct($collaterals) {
        $this->collaterals = $collaterals;
    }

    public function collection()
    {
        return Collateral::select([
'plan_id',
'party_type',
'party_id',
'deposit_type',
'deposit_number',
'contract_number',
'bank',
'issue_date',
'validity_period',
'amount'
])
        ->whereIn('id', $this->collaterals)->get();
    }
}


