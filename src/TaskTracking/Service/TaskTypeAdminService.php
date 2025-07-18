<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\TaskTypeAdminDto;
use Src\TaskTracking\Models\TaskType;

class TaskTypeAdminService
{
public function store(TaskTypeAdminDto $taskTypeAdminDto){
    return TaskType::create([
        'type_name' => $taskTypeAdminDto->type_name,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TaskType $taskType, TaskTypeAdminDto $taskTypeAdminDto){
    return tap($taskType)->update([
        'type_name' => $taskTypeAdminDto->type_name,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TaskType $taskType){
    return tap($taskType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TaskType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


