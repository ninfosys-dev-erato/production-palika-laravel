<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\PlanLevel;

class PlanLevelsExport implements FromCollection
{
    public $plan_levels;

    public function __construct($plan_levels) {
        $this->plan_levels = $plan_levels;
    }

    public function collection()
    {
        return PlanLevel::select([
'plan_level_id',
'level_name'
])
        ->whereIn('id', $this->plan_levels)->get();
    }
}


