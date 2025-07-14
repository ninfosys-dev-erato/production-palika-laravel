<?php

namespace Src\FuelSettings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\FuelSettings\Models\FuelSetting;

class FuelSettingsExport implements FromCollection
{
    public $fuel_settings;

    public function __construct($fuel_settings) {
        $this->fuel_settings = $fuel_settings;
    }

    public function collection()
    {
        return FuelSetting::select([
'acceptor_id',
'reviewer_id',
'expiry_days',
'ward_no'
])
        ->whereIn('id', $this->fuel_settings)->get();
    }
}


