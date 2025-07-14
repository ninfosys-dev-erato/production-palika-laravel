<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\TaskType;

class TaskTypeAdminDto
{
   public function __construct(
        public string $type_name
    ){}

public static function fromLiveWireModel(TaskType $taskType):TaskTypeAdminDto{
    return new self(
        type_name: $taskType->type_name
    );
}
}
