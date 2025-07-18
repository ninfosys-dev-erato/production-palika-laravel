<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Item;

class ItemAdminDto
{
   public function __construct(
        public string $title,
        public string $type_id,
        public string $code,
        public string $unit_id,
        public string $remarks
    ){}

public static function fromLiveWireModel(Item $item):ItemAdminDto{
    return new self(
        title: $item->title,
        type_id: $item->type_id,
        code: $item->code,
        unit_id: $item->unit_id,
        remarks: $item->remarks
    );
}
}
