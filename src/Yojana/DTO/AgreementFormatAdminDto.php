<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementFormat;

class AgreementFormatAdminDto
{
    public function __construct(
        public string $implementation_method_id,
        public string $name,
        public string $sample_letter,
        public ?string $styles
    ) {}

    public static function fromLiveWireModel(AgreementFormat $agreementFormat): AgreementFormatAdminDto
    {
        return new self(
            implementation_method_id: $agreementFormat->implementation_method_id,
            name: $agreementFormat->name,
            sample_letter: $agreementFormat->sample_letter,
            styles: $agreementFormat->styles
        );
    }
}
