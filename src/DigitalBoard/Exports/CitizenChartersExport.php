<?php

namespace Src\DigitalBoard\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DigitalBoard\Models\CitizenCharter;

class CitizenChartersExport implements FromCollection
{
    public $citizen_charters;

    public function __construct($citizen_charters)
    {
        $this->citizen_charters = $citizen_charters;
    }

    public function collection()
    {
        return CitizenCharter::select([
            'branch_id',
            'service',
            'required_document',
            'amount',
            'time',
            'responsible_person',
            'can_show_on_admin'
        ])
            ->whereIn('id', $this->citizen_charters)->get();
    }
}
