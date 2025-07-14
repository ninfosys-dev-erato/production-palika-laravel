<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\JudicialMember;

class JudicialMembersExport implements FromCollection
{
    public $judicial_members;

    public function __construct($judicial_members) {
        $this->judicial_members = $judicial_members;
    }

    public function collection()
    {
        return JudicialMember::select([
'title',
'member_position',
'elected_position',
'status'
])
        ->whereIn('id', $this->judicial_members)->get();
    }
}


