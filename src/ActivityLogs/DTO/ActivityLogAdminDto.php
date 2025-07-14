<?php

namespace Src\ActivityLogs\DTO;

use Src\ActivityLogs\Models\ActivityLog;

class ActivityLogAdminDto
{
   public function __construct(
        public string $log_name,
        public string $description,
        public string $subject_type,
        public string $event,
        public string $subject_id,
        public string $causer_type,
        public string $causer_id,
        public string $properties,
        public string $batch_uuid
    ){}

public static function fromLiveWireModel(ActivityLog $activityLog):ActivityLogAdminDto{
    return new self(
        log_name: $activityLog->log_name,
        description: $activityLog->description,
        subject_type: $activityLog->subject_type,
        event: $activityLog->event,
        subject_id: $activityLog->subject_id,
        causer_type: $activityLog->causer_type,
        causer_id: $activityLog->causer_id,
        properties: $activityLog->properties,
        batch_uuid: $activityLog->batch_uuid
    );
}
}
