<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Comment;
use Src\TaskTracking\Models\Task;

class CommentAdminDto
{
   public function __construct(
        public string $task_id,
        public string $content,
        public string $commenter_type,
        public string $commenter_id
    ){}

public static function fromLiveWireModel(Task $task, $model, $files ): CommentAdminDto
{
    return new self(
        task_id: $task->id,
        content: $files,
        commenter_type: $model,
        commenter_id: auth()->id(),
    );
}
}
