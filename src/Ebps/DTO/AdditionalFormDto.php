<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\AdditionalForm;

class AdditionalFormDto
{
    public function __construct(
        public ?string $name,
        public ?int $form_id,

    ) {}


    public static function fromLiveWireModel(AdditionalForm $additionalForm): AdditionalFormDto
    {
        return new self(
            name: $additionalForm->name,
            form_id: $additionalForm->form_id,

        );
    }
}
