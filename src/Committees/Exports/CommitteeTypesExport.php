<?php

namespace Src\Committees\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Committees\Models\CommitteeType;

class CommitteeTypesExport implements FromCollection
{
    public $committee_types;

    public function __construct($committee_types) {
        $this->committee_types = $committee_types;
    }

    public function collection()
    {
        return CommitteeType::select([
        'name',
        'committee_no'
        ])
        ->whereIn('id', $this->committee_types)->get();
    }
}


