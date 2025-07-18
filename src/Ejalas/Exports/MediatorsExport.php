<?php

namespace Src\Ejalas\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ejalas\Models\Mediator;

class MediatorsExport implements FromCollection
{
    public $mediators;

    public function __construct($mediators) {
        $this->mediators = $mediators;
    }

    public function collection()
    {
        return Mediator::select([
'fiscal_year_id',
'listed_no',
'mediator_name',
'mediator_address',
'ward_id',
'training_detail',
'mediator_phone_no',
'mediator_email',
'municipal_approval_date'
])
        ->whereIn('id', $this->mediators)->get();
    }
}


