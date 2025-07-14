<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\ReconciliationCenter;

class ReconciliationCentersExport implements FromCollection
{
    public $reconciliation_centers;

    public function __construct($reconciliation_centers) {
        $this->reconciliation_centers = $reconciliation_centers;
    }

    public function collection()
    {
        return ReconciliationCenter::select([
'reconciliation_center_title',
'surname',
'title',
'subtile',
'ward_id',
'established_date'
])
        ->whereIn('id', $this->reconciliation_centers)->get();
    }
}


