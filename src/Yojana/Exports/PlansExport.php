<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Plan;

class PlansExport implements FromCollection
{
    public $plans;

    public function __construct($plans) {
        $this->plans = $plans;
    }

    public function collection()
    {
        return Plan::select([
'project_name',
'implementation_method_id',
'location',
'ward_id',
'start_fiscal_year_id',
'operate_fiscal_year_id',
'area_id',
'sub_region_id',
'targeted_id',
'implementation_level_id',
'plan_type',
'nature',
'project_group_id',
'purpose',
'red_book_detail',
'allocated_budget',
'source_id',
'program',
'budget_head_id',
'expense_head_id',
'fiscal_year_id',
'amount'
])
        ->whereIn('id', $this->plans)->get();
    }
}


