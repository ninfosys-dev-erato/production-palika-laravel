<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ConsumerCommitteeOfficial;

class ConsumerCommitteeOfficialsExport implements FromCollection
{
    public $consumer_committee_officials;

    public function __construct($consumer_committee_officials) {
        $this->consumer_committee_officials = $consumer_committee_officials;
    }

    public function collection()
    {
        return ConsumerCommitteeOfficial::select([
'consumer_committee_id',
'post',
'name',
'father_name',
'grandfather_name',
'address',
'gender',
'phone',
'citizenship_no'
])
        ->whereIn('id', $this->consumer_committee_officials)->get();
    }
}


