<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\MapPassGroup;

class MapPassGroupsExport implements FromCollection
{
    public $map_pass_groups;

    public function __construct($map_pass_groups) {
        $this->map_pass_groups = $map_pass_groups;
    }

    public function collection()
    {
        return MapPassGroup::select([
'title'
])
        ->whereIn('id', $this->map_pass_groups)->get();
    }
}


