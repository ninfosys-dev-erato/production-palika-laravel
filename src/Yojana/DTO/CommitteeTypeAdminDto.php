<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\CommitteeType;

class CommitteeTypeAdminDto
{
    public function __construct(
        public string $name,
        public string $name_en,
        public string $code,
    ) {
    }

    public static function fromLiveWireModel(CommitteeType $committeeType): CommitteeTypeAdminDto
    {
        return new self(
            name: $committeeType->name,
            name_en: $committeeType->name_en,
            code: $committeeType->code ?? '',
        );
    }
}
