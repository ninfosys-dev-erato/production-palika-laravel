<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\DisputeArea;

class DisputeAreaAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(DisputeArea $disputeArea):DisputeAreaAdminDto{
    return new self(
        title: $disputeArea->title,
        title_en: $disputeArea->title_en
    );
}
}
