<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectGroup;

class ProjectGroupsExport implements FromCollection
{
    public $project_groups;

    public function __construct($project_groups) {
        $this->project_groups = $project_groups;
    }

    public function collection()
    {
        return ProjectGroup::select([
'title',
'group_id',
'area_id',
'code'
])
        ->whereIn('id', $this->project_groups)->get();
    }
}


