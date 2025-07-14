<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\FuelDemand;

class FuelDemandsExport implements FromCollection
{
    public $fuel_demands;

    public function __construct($fuel_demands) {
        $this->fuel_demands = $fuel_demands;
    }

    public function collection()
    {
        return FuelDemand::select([
'fuel_id',
'equipment_id',
'quantity'
])
        ->whereIn('id', $this->fuel_demands)->get();
    }
}


