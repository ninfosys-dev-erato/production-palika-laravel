<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ConsumerCommitteeTransaction;

class ConsumerCommitteeTransactionsExport implements FromCollection
{
    public $consumer_committee_transactions;

    public function __construct($consumer_committee_transactions) {
        $this->consumer_committee_transactions = $consumer_committee_transactions;
    }

    public function collection()
    {
        return ConsumerCommitteeTransaction::select([
'project_id',
'type',
'date',
'amount',
'remarks'
])
        ->whereIn('id', $this->consumer_committee_transactions)->get();
    }
}


