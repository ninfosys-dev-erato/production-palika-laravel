<?php

namespace Src\TaskTracking\Service;


use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\TaskAdminDto;
use Src\TaskTracking\Enums\TaskStatus;
use Src\TaskTracking\Jobs\SendTaskNotificationJob;
use Src\TaskTracking\Models\Task;
use Src\TaskTracking\Notifications\TaskAssignedNotification;
use Src\TaskTracking\Notifications\TaskReporterNotification;

class TaskAdminService
{
public function store(TaskAdminDto $taskAdminDto){
    $task =  Task::create([
        'project_id' => $taskAdminDto->project_id,
        'task_type_id' => $taskAdminDto->task_type_id,
        'task_no' => $taskAdminDto->task_no,
        'title' => $taskAdminDto->title,
        'description' => $taskAdminDto->description,
        'status' => $taskAdminDto->status,
        'assignee_type' => $taskAdminDto->assignee_type,
        'assignee_id' => $taskAdminDto->assignee_id,
        'reporter_type' => $taskAdminDto->reporter_type,
        'reporter_id' => $taskAdminDto->reporter_id,
        'start_date' => $taskAdminDto->start_date,
        'end_date' => $taskAdminDto->end_date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);

    //SendTaskNotificationJob::dispatch($task, true, true);

    return $task;
}
public function update(Task $task, TaskAdminDto $taskAdminDto){

    $data = Task::where('id', $task->id)->first();

    $assigneeChanged = $data->assignee_id !== $taskAdminDto->assignee_id;
    $reporterChanged = $data->reporter_id !== $taskAdminDto->reporter_id;

    $task = tap($task)->update([
        'project_id' => $taskAdminDto->project_id,
        'task_type_id' => $taskAdminDto->task_type_id,
        'task_no' => $taskAdminDto->task_no,
        'title' => $taskAdminDto->title,
        'description' => $taskAdminDto->description,
        'status' => $taskAdminDto->status,
        'assignee_type' => $taskAdminDto->assignee_type,
        'assignee_id' => $taskAdminDto->assignee_id,
        'reporter_type' => $taskAdminDto->reporter_type,
        'reporter_id' => $taskAdminDto->reporter_id,
        'start_date' => $taskAdminDto->start_date,
        'end_date' => $taskAdminDto->end_date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);

    // if ($assigneeChanged || $reporterChanged) {
    //     SendTaskNotificationJob::dispatch($task, $assigneeChanged, $reporterChanged);
    // }

    return $task;
}
public function delete(Task $task){
    return tap($task)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function updateStatus(Task $task, TaskStatus $status){
     $task->update([
        'status' => $status,
    ]);
    return $task;
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Task::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


