<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\FormType;

class FormTypeAdminDto
{
    public function __construct(
        public string $name,
        public string $form_id,
        public ?bool $status,
        public ?string $form_type
    ){}

    public static function fromLiveWireModel(FormType $formType): FormTypeAdminDto
    {
        return new self(
            name: $formType->name,
            form_id: $formType->form_id,
            status: $formType->status ?? true,
            form_type: $formType->form_type
        );
    }
}
