<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BenefitedMember;

class BenefitedMembersExport implements FromCollection
{
    public $benefited_members;

    public function __construct($benefited_members) {
        $this->benefited_members = $benefited_members;
    }

    public function collection()
    {
        return BenefitedMember::select([
'title',
'is_population'
])
        ->whereIn('id', $this->benefited_members)->get();
    }
}


