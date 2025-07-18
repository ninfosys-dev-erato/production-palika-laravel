<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\HelplessnessType;

class HelplessnessTypeAdminDto
{
    public function __construct(
        public string $helplessness_type,
        public string $helplessness_type_en
    ) {
    }

    public static function fromLiveWireModel(HelplessnessType $helplessnessType): HelplessnessTypeAdminDto
    {
        return new self(
            helplessness_type: $helplessnessType->helplessness_type,
            helplessness_type_en: $helplessnessType->helplessness_type_en
        );
    }
}
