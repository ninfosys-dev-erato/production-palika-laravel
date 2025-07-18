<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Criterion;

class CriteriaExport implements FromCollection
{
    public $criteria;

    public function __construct($criteria) {
        $this->criteria = $criteria;
    }

    public function collection()
    {
        return Criterion::select([
'name',
'name_en',
'max_score',
'min_score'
])
        ->whereIn('id', $this->criteria)->get();
    }
}


