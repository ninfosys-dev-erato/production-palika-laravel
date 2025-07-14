<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\Configuration;

class ConfigurationsExport implements FromCollection
{
    public $configurations;

    public function __construct($configurations) {
        $this->configurations = $configurations;
    }

    public function collection()
    {
        return Configuration::select([
'title',
'amount',
'type',
'use_in_cost_estimation',
'use_in_payment'
])
        ->whereIn('id', $this->configurations)->get();
    }
}


