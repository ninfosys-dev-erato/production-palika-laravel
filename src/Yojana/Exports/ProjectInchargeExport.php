<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectIncharge;

class ProjectInchargeExport implements FromCollection
{
    public $project_incharges;

    public function __construct($project_incharges) {
        $this->project_incharges = $project_incharges;
    }

    public function collection()
    {
        return ProjectIncharge::select([
'employee_id',
'remarks',
'is_active'
])
        ->whereIn('id', $this->project_incharges)->get();
    }
}


