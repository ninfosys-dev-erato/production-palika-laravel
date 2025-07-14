<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\LetterType;

class LetterTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(LetterType $letterType):LetterTypeAdminDto{
    return new self(
        title: $letterType->title
    );
}
}
