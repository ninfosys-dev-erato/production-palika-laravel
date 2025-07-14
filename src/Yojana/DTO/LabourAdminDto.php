<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Labour;

class LabourAdminDto
{
   public function __construct(
        public string $title,
        public string $unit_id
    ){}

public static function fromLiveWireModel(Labour $labour):LabourAdminDto{
    return new self(
        title: $labour->title,
        unit_id: $labour->unit_id
    );
}
}
