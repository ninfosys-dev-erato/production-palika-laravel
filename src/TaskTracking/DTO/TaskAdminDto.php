<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Task;

class TaskAdminDto
{
   public function __construct(
        public string $project_id,
        public string $task_type_id,
        public string $task_no,
        public string $title,
        public string $description,
        public string $status,
        public string $assignee_type,
        public string $assignee_id,
        public string $reporter_type,
        public string $reporter_id,
        public string $start_date,
        public string $end_date
    ){}

public static function fromLiveWireModel(Task $task):TaskAdminDto{
    return new self(
        project_id: $task->project_id,
        task_type_id: $task->task_type_id,
        task_no: $task->task_no,
        title: $task->title,
        description: $task->description,
        status: $task->status,
        assignee_type: $task->assignee_type,
        assignee_id: $task->assignee_id,
        reporter_type: $task->reporter_type,
        reporter_id: $task->reporter_id,
        start_date: $task->start_date,
        end_date: $task->end_date
    );
}
}
