<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\LetterSample;

class LetterSampleAdminDto
{
    public function __construct(
        public LetterTypes $letter_type,
        public string $implementation_method_id,
        public string $name,
        public string $subject,
        public string $sample_letter,
        public ?string $styles,
    ) {}

    public static function fromLiveWireModel(LetterSample $letterSample): LetterSampleAdminDto
    {
        return new self(
            letter_type: $letterSample->letter_type,
            implementation_method_id: $letterSample->implementation_method_id,
            name: $letterSample->name,
            subject: $letterSample->subject,
            sample_letter: $letterSample->sample_letter,
            styles: $letterSample->styles
        );
    }
}
