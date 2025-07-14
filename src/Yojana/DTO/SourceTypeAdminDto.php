<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\SourceType;

class SourceTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $code
    ){}

public static function fromLiveWireModel(SourceType $sourceType):SourceTypeAdminDto{
    return new self(
        title: $sourceType->title,
        code: $sourceType->code
    );
}
}
