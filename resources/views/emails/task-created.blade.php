@component('mail::message')
    # A New Task Has Been Created!

    Hello {{ $reporter->name }},

    A new task has been created, and you are the reporter for this task.

    Project: {{ $task->project->title }}
    Task Type: {{ $task->taskType->task_name }}
    Task Title: {{ $task->title }}
    Task Description: {{ strip_tags($task->description) }}
    Assignee: {{ $assignee }}
    Start Date: {{ $task->start_date }}
    End Date: {{ $task->end_date }}

    Please review the task and stay updated on its progress.

    Thanks,
    E-Palika
@endcomponent
