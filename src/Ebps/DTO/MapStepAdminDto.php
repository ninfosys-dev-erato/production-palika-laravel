<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapStep;

class MapStepAdminDto
{
   public function __construct(
        public ?string $title,
        public ?bool $is_public,
        public ?bool $can_skip,
        public ?string $form_submitter,
        public ?string $form_position,
        public ?string $step_for,
        public ?string $application_type,
    ){}

public static function fromLiveWireModel(MapStep $mapStep):MapStepAdminDto{
    return new self(
        title: $mapStep->title,
        is_public: $mapStep->is_public ?? false,
        can_skip: $mapStep->can_skip ?? false,
        form_submitter: $mapStep->form_submitter,
        form_position: $mapStep->form_position,
        step_for: $mapStep->step_for,
        application_type: $mapStep->application_type
    );
}
}
