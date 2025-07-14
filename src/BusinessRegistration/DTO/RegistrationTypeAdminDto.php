<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\RegistrationType;

class RegistrationTypeAdminDto
{
    public function __construct(
        public string  $title,
        public ?string $form_id,
        public string  $registration_category_id,
        public ?string $department_id,
        public ?BusinessRegistrationType $action,
    ) {}

    public static function fromLiveWireModel(RegistrationType $regType)
    {
        return new self(
            title: $regType->title,
            form_id: $regType->form_id ?? null,
            registration_category_id: $regType->registration_category_id ?? null,
            department_id: $regType->department_id ?? null,
            action: $regType->action ?? null,
        );
    }
}
