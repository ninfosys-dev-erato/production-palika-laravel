<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectMaintenanceArrangement;

class ProjectMaintenanceArrangementsExport implements FromCollection
{
    public $project_maintenance_arrangements;

    public function __construct($project_maintenance_arrangements) {
        $this->project_maintenance_arrangements = $project_maintenance_arrangements;
    }

    public function collection()
    {
        return ProjectMaintenanceArrangement::select([
'project_id',
'office_name',
'public_service',
'service_fee',
'from_fee_donation',
'others'
])
        ->whereIn('id', $this->project_maintenance_arrangements)->get();
    }
}


