<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Committee;

class CommitteesExport implements FromCollection
{
    public $committees;

    public function __construct($committees)
    {
        $this->committees = $committees;
    }

    public function collection()
    {
        return Committee::select([
            'committee_type_id',
            'committee_name',
        ])
            ->whereIn('id', $this->committees)->get();
    }
}


