<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\Level;

class LevelAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(Level $level):LevelAdminDto{
    return new self(
        title: $level->title,
        title_en: $level->title_en
    );
}
}
