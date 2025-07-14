<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\TaskType;

class TaskTypesExport implements FromCollection
{
    public $task_types;

    public function __construct($task_types) {
        $this->task_types = $task_types;
    }

    public function collection()
    {
        return TaskType::select([
'type_name'
])
        ->whereIn('id', $this->task_types)->get();
    }
}


