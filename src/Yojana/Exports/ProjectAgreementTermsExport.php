<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectAgreementTerm;

class ProjectAgreementTermsExport implements FromCollection
{
    public $project_agreement_terms;

    public function __construct($project_agreement_terms) {
        $this->project_agreement_terms = $project_agreement_terms;
    }

    public function collection()
    {
        return ProjectAgreementTerm::select([
'project_id',
'data'
])
        ->whereIn('id', $this->project_agreement_terms)->get();
    }
}


