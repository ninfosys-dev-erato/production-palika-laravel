<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\BenefitedMemberDetail;

class BenefitedMemberDetailsExport implements FromCollection
{
    public $benefited_member_details;

    public function __construct($benefited_member_details) {
        $this->benefited_member_details = $benefited_member_details;
    }

    public function collection()
    {
        return BenefitedMemberDetail::select([
'project_id',
'ward_no',
'village',
'dalit_backward_no',
'other_households_no',
'no_of_male',
'no_of_female',
'no_of_others'
])
        ->whereIn('id', $this->benefited_member_details)->get();
    }
}


