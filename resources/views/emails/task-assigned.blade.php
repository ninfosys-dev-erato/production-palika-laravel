@component('mail::message')
    # A New Task Has Been Assigned to You!

    Hello {{ $assignee->name }},

    A new task has been assigned to you.

    Project: {{ $task->project->title }}
    Task Type: {{ $task->taskType->task_name }}
    Task Title: {{ $task->title }}
    Task Description: {{ strip_tags($task->description) }}
    Reporter: {{ $reporter }}
    Start Date: {{ $task->start_date }}
    End Date: {{ $task->end_date }}

    Please review the task and take the necessary actions.

    Thanks,
    E-Palika
@endcomponent
