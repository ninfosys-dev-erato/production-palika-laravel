<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ConsumerCommitteeMember;

class ConsumerCommitteeMembersExport implements FromCollection
{
    public $consumer_committee_members;

    public function __construct($consumer_committee_members) {
        $this->consumer_committee_members = $consumer_committee_members;
    }

    public function collection()
    {
        return ConsumerCommitteeMember::select([
'citizenship_number',
'name',
'gender',
'father_name',
'husband_name',
'grandfather_name',
'father_in_law_name',
'is_monitoring_committee',
'designation',
'address',
'is_account_holder',
'citizenship_upload'
])
        ->whereIn('id', $this->consumer_committee_members)->get();
    }
}


