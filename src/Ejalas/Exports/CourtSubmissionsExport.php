<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\CourtSubmission;

class CourtSubmissionsExport implements FromCollection
{
    public $court_submissions;

    public function __construct($court_submissions) {
        $this->court_submissions = $court_submissions;
    }

    public function collection()
    {
        return CourtSubmission::select([
'complaint_registration_id',
'discussion_date',
'submission_decision_date',
'decision_authority_id'
])
        ->whereIn('id', $this->court_submissions)->get();
    }
}


