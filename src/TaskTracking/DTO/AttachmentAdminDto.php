<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Attachment;
use Src\TaskTracking\Models\Task;

class AttachmentAdminDto
{
   public function __construct(
        public array $file,
        public string $attachable_type,
        public string $attachable_id
    ){}

public static function fromLiveWireModel($task, $model, $files ):AttachmentAdminDto{
    return new self(
        file: $files,
        attachable_type: $model,
        attachable_id: $task->id
    );
}
}
