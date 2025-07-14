<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProcessIndicator;

class ProcessIndicatorAdminDto
{
   public function __construct(
        public string $title,
        public string $unit_id,
        public string $code
    ){}

public static function fromLiveWireModel(ProcessIndicator $processIndicator):ProcessIndicatorAdminDto{
    return new self(
        title: $processIndicator->title,
        unit_id: $processIndicator->unit_id,
        code: $processIndicator->code
    );
}
}
