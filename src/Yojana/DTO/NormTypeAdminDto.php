<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\NormType;

class NormTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $authority_name,
        public string $year
    ){}

public static function fromLiveWireModel(NormType $normType):NormTypeAdminDto{
    return new self(
        title: $normType->title,
        authority_name: $normType->authority_name,
        year: $normType->year
    );
}
}
