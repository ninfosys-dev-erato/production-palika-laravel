<?php

namespace Src\Settings\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Settings\Models\SettingGroup;

class SettingGroupsExport implements FromCollection
{
    public $setting_groups;

    public function __construct($setting_groups) {
        $this->setting_groups = $setting_groups;
    }

    public function collection()
    {
        return SettingGroup::select([
'group_name',
'description'
])
        ->whereIn('id', $this->setting_groups)->get();
    }
}


