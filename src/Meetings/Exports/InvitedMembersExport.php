<?php

namespace Src\Meetings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Meetings\Models\InvitedMember;

class InvitedMembersExport implements FromCollection
{
    public $invited_members;

    public function __construct($invited_members) {
        $this->invited_members = $invited_members;
    }

    public function collection()
    {
        return InvitedMember::select([
'name',
'meeting_id',
'designation',
'phone',
'email'
])
        ->whereIn('id', $this->invited_members)->get();
    }
}