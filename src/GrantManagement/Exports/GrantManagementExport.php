<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\GrantManagement\Models\Grant;

class GrantManagementExport implements FromCollection
{
    public $grants;

    public function __construct($grants)
    {
        $this->grants = $grants;
    }

    public function collection()
    {
        return Grant::select([
            'fiscal_year_id',
            'grant_type_id',
            'grant_office_id',
            'grant_program_name',
            'branch_id',
            'grant_amount',
            'grant_for',
            'main_activity',
            'remarks',
            'user_id'
        ])
            ->whereIn('id', $this->grants)->get();
    }
}


