<?php

namespace Src\Settings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Settings\Models\Setting;

class SettingsExport implements FromCollection
{
    public $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }

    public function collection()
    {
        return Setting::select([
'group_id',
'label',
'value',
'key_id',
'key_type',
'key_needle',
'key',
'description'
])
        ->whereIn('id', $this->settings)->get();
    }
}


