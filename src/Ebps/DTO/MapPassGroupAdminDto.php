<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapPassGroup;

class MapPassGroupAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(MapPassGroup $mapPassGroup):MapPassGroupAdminDto{
    return new self(
        title: $mapPassGroup->title
    );
}
}
