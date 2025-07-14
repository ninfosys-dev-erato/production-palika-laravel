<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectInstallmentDetail;

class ProjectInstallmentDetailsExport implements FromCollection
{
    public $project_installment_details;

    public function __construct($project_installment_details) {
        $this->project_installment_details = $project_installment_details;
    }

    public function collection()
    {
        return ProjectInstallmentDetail::select([
'project_id',
'installment_type',
'date',
'amount',
'construction_material_quantity',
'remarks'
])
        ->whereIn('id', $this->project_installment_details)->get();
    }
}


