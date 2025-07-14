<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectDeadlineExtension;

class ProjectDeadlineExtensionsExport implements FromCollection
{
    public $project_deadline_extensions;

    public function __construct($project_deadline_extensions) {
        $this->project_deadline_extensions = $project_deadline_extensions;
    }

    public function collection()
    {
        return ProjectDeadlineExtension::select([
'project_id',
'extended_date',
'en_extended_date',
'submitted_date',
'en_submitted_date',
'remarks'
])
        ->whereIn('id', $this->project_deadline_extensions)->get();
    }
}


