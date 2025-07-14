<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Task;

class TasksExport implements FromCollection
{
    public $tasks;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function collection()
    {
        return Task::select([
'project_id',
'task_type_id',
'task_no',
'title',
'description',
'status',
'assignee_type',
'assignee_id',
'reporter_type',
'reporter_id',
'start_date',
'end_date'
])
        ->whereIn('id', $this->tasks)->get();
    }
}


