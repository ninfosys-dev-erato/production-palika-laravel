<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Equipment;

class EquipmentExport implements FromCollection
{
    public $equipment;

    public function __construct($equipment) {
        $this->equipment = $equipment;
    }

    public function collection()
    {
        return Equipment::select([
'title',
'activity',
'is_used_for_transport',
'capacity',
'speed_with_out_load'
])
        ->whereIn('id', $this->equipment)->get();
    }
}


