<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ItemType;

class ItemTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $code,
        public string $group
    ){}

public static function fromLiveWireModel(ItemType $itemType):ItemTypeAdminDto{
    return new self(
        title: $itemType->title,
        code: $itemType->code,
        group: $itemType->group
    );
}
}
