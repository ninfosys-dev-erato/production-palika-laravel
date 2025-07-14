<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Project;

class ProjectsExport implements FromCollection
{
    public $projects;

    public function __construct($projects) {
        $this->projects = $projects;
    }

    public function collection()
    {
        return Project::select([
'title',
'description'
])
        ->whereIn('id', $this->projects)->get();
    }
}


