<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BankDetail;

class BankDetailsExport implements FromCollection
{
    public $bank_details;

    public function __construct($bank_details) {
        $this->bank_details = $bank_details;
    }

    public function collection()
    {
        return BankDetail::select([
'title',
'branch'
])
        ->whereIn('id', $this->bank_details)->get();
    }
}


