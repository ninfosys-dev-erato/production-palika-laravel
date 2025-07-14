<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectActivityGroup;

class ProjectActivityGroupsExport implements FromCollection
{
    public $project_activity_groups;

    public function __construct($project_activity_groups) {
        $this->project_activity_groups = $project_activity_groups;
    }

    public function collection()
    {
        return ProjectActivityGroup::select([
'title',
'code',
'group_id',
'norms_type'
])
        ->whereIn('id', $this->project_activity_groups)->get();
    }
}


