<?php

namespace Src\Settings\DTO;

use Src\Settings\Models\LetterHeadSample;

class LetterHeadSampleAdminDto
{
    public function __construct(
        public string $name,
        public string $content,
        public string $slug,
        public ?string $style = null
    ) {}

    public static function fromLiveWireModel(LetterHeadSample $letterHeadSample): LetterHeadSampleAdminDto
    {
        return new self(
            name: $letterHeadSample->name,
            content: $letterHeadSample->content,
            slug: $letterHeadSample->slug->value,
            style: $letterHeadSample->style
        );
    }
}
