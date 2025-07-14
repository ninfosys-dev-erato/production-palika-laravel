<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\PlanArea;

class PlanAreasExport implements FromCollection
{
    public $plan_areas;

    public function __construct($plan_areas) {
        $this->plan_areas = $plan_areas;
    }

    public function collection()
    {
        return PlanArea::select([
'plan_area_id',
'area_name'
])
        ->whereIn('id', $this->plan_areas)->get();
    }
}


