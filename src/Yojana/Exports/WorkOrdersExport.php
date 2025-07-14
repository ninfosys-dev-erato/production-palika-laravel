<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\WorkOrder;

class WorkOrdersExport implements FromCollection
{
    public $work_orders;

    public function __construct($work_orders) {
        $this->work_orders = $work_orders;
    }

    public function collection()
    {
        return WorkOrder::select([
'date',
'plan_id',
'plan_name',
'subject',
'letter_body'
])
        ->whereIn('id', $this->work_orders)->get();
    }
}


