<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\JudicialCommittee;

class JudicialCommitteesExport implements FromCollection
{
    public $judicial_committees;

    public function __construct($judicial_committees) {
        $this->judicial_committees = $judicial_committees;
    }

    public function collection()
    {
        return JudicialCommittee::select([
'ommittees_title',
'short_title',
'title',
'subtitle',
'formation_date',
'phone_no',
'email'
])
        ->whereIn('id', $this->judicial_committees)->get();
    }
}


