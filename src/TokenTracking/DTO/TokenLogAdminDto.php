<?php

namespace Src\TokenTracking\DTO;

use Src\TokenTracking\Models\TokenLog;

class TokenLogAdminDto
{
   public function __construct(
        public ?string $token_id,
        public ?string $old_status,
        public ?string $new_status,
        public ?string $status,
        public ?string $stage_status,
        public ?string $old_branch,
        public ?string $new_branch
    ){}

public static function fromLiveWireModel($registerToken):TokenLogAdminDto
{
    return new self(
        token_id: $tokenLog->token_id ?? null,
        old_status: $tokenLog->old_status ?? null,
        new_status: $tokenLog->new_status ?? null,
        status: $tokenLog->status ?? null,
        stage_status: $tokenLog->stage_status ?? null,
        old_branch: $tokenLog->old_branch ?? null,
        new_branch: $tokenLog->new_branch ?? null
    );
}
}
