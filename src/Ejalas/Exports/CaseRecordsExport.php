<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\CaseRecord;

class CaseRecordsExport implements FromCollection
{
    public $case_records;

    public function __construct($case_records)
    {
        $this->case_records = $case_records;
    }

    public function collection()
    {
        return CaseRecord::select([
            'complaint_registration_id',
            'discussion_date',
            'condition_fulfilled_date',
            'decision_date',
            'decision_authority_id',
            'recording_officer_name',
            'recording_officer_position',
            'remarks'
        ])
            ->whereIn('id', $this->case_records)->get();
    }
}
