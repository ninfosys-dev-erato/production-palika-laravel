<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Target;

class TargetAdminDto
{
   public function __construct(
        public string $title,
        public string $code
    ){}

public static function fromLiveWireModel(Target $target):TargetAdminDto{
    return new self(
        title: $target->title,
        code: $target->code
    );
}
}
