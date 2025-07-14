<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\Storey;

class StoreyAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(Storey $storey):StoreyAdminDto{
    return new self(
        title: $storey->title
    );
}
}
