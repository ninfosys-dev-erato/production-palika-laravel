<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\EquipmentAdditionalCost;

class EquipmentAdditionalCostsExport implements FromCollection
{
    public $equipment_additional_costs;

    public function __construct($equipment_additional_costs) {
        $this->equipment_additional_costs = $equipment_additional_costs;
    }

    public function collection()
    {
        return EquipmentAdditionalCost::select([
'equipment_id',
'fiscal_year_id',
'unit_id',
'rate'
])
        ->whereIn('id', $this->equipment_additional_costs)->get();
    }
}


