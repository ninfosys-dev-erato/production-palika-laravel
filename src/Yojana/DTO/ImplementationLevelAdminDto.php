<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ImplementationLevel;

class ImplementationLevelAdminDto
{
   public function __construct(
        public string $title,
        public string $code,
        public string $threshold
    ){}

public static function fromLiveWireModel(ImplementationLevel $implementationLevel):ImplementationLevelAdminDto{
    return new self(
        title: $implementationLevel->title,
        code: $implementationLevel->code,
        threshold: $implementationLevel->threshold
    );
}
}
