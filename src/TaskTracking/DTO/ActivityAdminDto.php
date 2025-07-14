<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Enums\TaskStatus;
use Src\TaskTracking\Models\Attachment;
use Src\TaskTracking\Models\Task;

class ActivityAdminDto
{
   public function __construct(
    public ?int $task_id,
    public string $action,
    public ?int $user_id = null,
    public ?string $user_type = null,
    public ?string $description = null,
    ){}

public static function fromLiveWireModel($task, $action, $model, $description ):ActivityAdminDto{
    return new self(
        task_id: $task->id,
        action: $action,
        user_id: auth()->user()->id,
        user_type: $model,
        description: $description,
    );
}
}
