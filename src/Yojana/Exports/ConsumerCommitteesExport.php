<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ConsumerCommittee;

class ConsumerCommitteesExport implements FromCollection
{
    public $consumer_committees;

    public function __construct($consumer_committees) {
        $this->consumer_committees = $consumer_committees;
    }

    public function collection()
    {
        return ConsumerCommittee::select([
'committee_type_id',
'registration_number',
'formation_date',
'name',
'ward_id',
'address',
'creating_body',
'bank_id',
'account_number',
'formation_minute'
])
        ->whereIn('id', $this->consumer_committees)->get();
    }
}


