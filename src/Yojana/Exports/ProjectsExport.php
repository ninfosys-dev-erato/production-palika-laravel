<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Project;

class ProjectsExport implements FromCollection
{
    public $projects;

    public function __construct($projects) {
        $this->projects = $projects;
    }

    public function collection()
    {
        return Project::select([
'registration_no',
'fiscal_year_id',
'project_name',
'plan_area_id',
'project_status',
'project_start_date',
'project_completion_date',
'plan_level_id',
'ward_no',
'allocated_amount',
'project_venue',
'evaluation_amount',
'purpose',
'operated_through',
'progress_spent_amount',
'physical_progress_target',
'physical_progress_completed',
'physical_progress_unit',
'first_quarterly_amount',
'first_quarterly_goal',
'second_quarterly_amount',
'second_quarterly_goal',
'third_quarterly_amount',
'third_quarterly_goal',
'agencies_grants',
'share_amount',
'committee_share_amount',
'labor_amount',
'benefited_organization',
'others_benefited',
'expense_head_id',
'contingency_amount',
'other_taxes',
'is_contracted',
'contract_date'
])
        ->whereIn('id', $this->projects)->get();
    }
}


