<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\PlanTemplate;

class PlanTemplatesExport implements FromCollection
{
    public $plan_templates;

    public function __construct($plan_templates) {
        $this->plan_templates = $plan_templates;
    }

    public function collection()
    {
        return PlanTemplate::select([
'type',
'template_for',
'title',
'data'
])
        ->whereIn('id', $this->plan_templates)->get();
    }
}


