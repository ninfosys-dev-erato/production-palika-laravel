<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Type;

class TypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(Type $type):TypeAdminDto{
    return new self(
        title: $type->title
    );
}
}
