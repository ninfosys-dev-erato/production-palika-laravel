<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectBidSubmission;

class ProjectBidSubmissionsExport implements FromCollection
{
    public $project_bid_submissions;

    public function __construct($project_bid_submissions) {
        $this->project_bid_submissions = $project_bid_submissions;
    }

    public function collection()
    {
        return ProjectBidSubmission::select([
'project_id',
'submission_type',
'submission_no',
'date',
'amount',
'fiscal_year_id'
])
        ->whereIn('id', $this->project_bid_submissions)->get();
    }
}


