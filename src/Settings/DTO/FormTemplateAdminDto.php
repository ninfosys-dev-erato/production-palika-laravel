<?php

namespace Src\Settings\DTO;

use Src\Settings\Models\Form;

class FormTemplateAdminDto
{
    public function __construct(
        public string $template,
        public string $styles
    ){}

    public static function fromLiveWireModel(array $data): FormTemplateAdminDto
    {
        return new self(
            template: $data['template'],
            styles: $data['styles']??"",
        );
    }
}
