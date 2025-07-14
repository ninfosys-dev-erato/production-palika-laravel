<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\FormMapStep;

class FormMapStepAdminDto
{
   public function __construct(
        public string $form_id,
        public string $map_step_id,
        public string $can_be_null
    ){}

public static function fromLiveWireModel(FormMapStep $formMapStep):FormMapStepAdminDto{
    return new self(
        form_id: $formMapStep->form_id,
        map_step_id: $formMapStep->map_step_id,
        can_be_null: $formMapStep->can_be_null
    );
}
}
