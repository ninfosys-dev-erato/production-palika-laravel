<?php

namespace Src\TokenTracking\DTO;

use Src\TokenTracking\Models\RegisterTokenLog;

class RegisterTokenLogAdminDto
{
   public function __construct(
        public string $token_id,
        public string $old_branch,
        public string $current_branch,
        public string $old_stage,
        public string $current_stage,
        public string $old_status,
        public string $current_status,
        public string $old_values,
        public string $current_values,
        public string $description
    ){}

public static function fromLiveWireModel(RegisterTokenLog $registerTokenLog):RegisterTokenLogAdminDto{
    return new self(
        token_id: $registerTokenLog->token_id,
        old_branch: $registerTokenLog->old_branch,
        current_branch: $registerTokenLog->current_branch,
        old_stage: $registerTokenLog->old_stage,
        current_stage: $registerTokenLog->current_stage,
        old_status: $registerTokenLog->old_status,
        current_status: $registerTokenLog->current_status,
        old_values: $registerTokenLog->old_values,
        current_values: $registerTokenLog->current_values,
        description: $registerTokenLog->description
    );
}
}
