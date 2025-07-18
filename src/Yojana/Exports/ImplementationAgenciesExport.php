<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ImplementationAgency;

class ImplementationAgenciesExport implements FromCollection
{
    public $implementation_agencies;

    public function __construct($implementation_agencies) {
        $this->implementation_agencies = $implementation_agencies;
    }

    public function collection()
    {
        return ImplementationAgency::select([
'plan_id',
'consumer_committee_id',
'model',
'comment',
'agreement_application',
'agreement_recommendation_letter',
'deposit_voucher'
])
        ->whereIn('id', $this->implementation_agencies)->get();
    }
}


