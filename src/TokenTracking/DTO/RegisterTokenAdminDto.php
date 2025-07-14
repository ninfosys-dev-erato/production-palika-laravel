<?php

namespace Src\TokenTracking\DTO;

use Src\TokenTracking\Enums\TokenPurposeEnum;
use Src\TokenTracking\Models\RegisterToken;

class RegisterTokenAdminDto
{
   public function __construct(
        public string $token,
        public ?TokenPurposeEnum $token_purpose,
        public string $fiscal_year,
        public string $date,
        public string $date_en,
        public ?string $branches,
        public string $current_branch,
        public ?string $entry_time,
        public ?string $exit_time,
        public ?string $estimated_time
    ){}

public static function fromLiveWireModel(RegisterToken $registerToken):RegisterTokenAdminDto{
    return new self(
        token: $registerToken->token,
        token_purpose: $registerToken->token_purpose,
        fiscal_year: $registerToken->fiscal_year,
        date: $registerToken->date,
        date_en: $registerToken->date_en,
        branches: $registerToken->branches ?? null,
        current_branch: $registerToken->current_branch,
        entry_time: $registerToken->entry_time??"",
        exit_time: $registerToken->exit_time??null,
        estimated_time: $registerToken->estimated_time??""
    );
}
}
