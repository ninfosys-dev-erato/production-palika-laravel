<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\CommitteeMember;

class CommitteeMembersExport implements FromCollection
{
    public $committee_members;

    public function __construct($committee_members) {
        $this->committee_members = $committee_members;
    }

    public function collection()
    {
        return CommitteeMember::select([
        'committee_id',
        'name',
        'designation',
        'phone',
        'photo',
        'email',
        'province_id',
        'district_id',
        'local_body_id',
        'ward_no',
        'tole',
        'position',
        'user_id'
        ])
        ->whereIn('id', $this->committee_members)->get();
    }
}


