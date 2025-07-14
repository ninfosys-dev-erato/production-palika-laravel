<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\MediatorSelection;

class MediatorSelectionAdminDto
{
   public function __construct(
        public string $complaint_registration_id,
        public string $mediator_id,
        public string $mediator_type,
        public string $selection_date
    ){}

public static function fromLiveWireModel(MediatorSelection $mediatorSelection):MediatorSelectionAdminDto{
    return new self(
        complaint_registration_id: $mediatorSelection->complaint_registration_id,
        mediator_id: $mediatorSelection->mediator_id,
        mediator_type: $mediatorSelection->mediator_type,
        selection_date: $mediatorSelection->selection_date
    );
}
}
