<?php

namespace Src\Settings\DTO;

use Src\Settings\Models\Form;

class FormAdminDto
{
    public function __construct(
        public string $title,
        public ?string $template = null,
        public array $fields = [],
        public string $module,
    ){}

    public static function fromLiveWireModel(array $data): FormAdminDto
    {
        return new self(
            title: $data['title'],
            template: $data['template'] ?? null,
            fields: $data['fields'] ?? [],
            module: $data['module']
        );
    }
}
