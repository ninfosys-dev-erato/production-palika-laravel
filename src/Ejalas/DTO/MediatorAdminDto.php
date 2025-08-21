<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\Mediator;

class MediatorAdminDto
{
    public function __construct(
        public ?string $fiscal_year_id,
        public ?string $listed_no,
        public ?string $mediator_name,
        public ?string $mediator_address,
        public ?string $ward_id,
        public ?string $training_detail,
        public ?string $mediator_phone_no,
        public ?string $mediator_email,
        public ?string $municipal_approval_date
    ) {}

    public static function fromLiveWireModel(Mediator $mediator): MediatorAdminDto
    {
        return new self(
            fiscal_year_id: $mediator->fiscal_year_id,
            listed_no: $mediator->listed_no,
            mediator_name: $mediator->mediator_name,
            mediator_address: $mediator->mediator_address,
            ward_id: $mediator->ward_id,
            training_detail: $mediator->training_detail,
            mediator_phone_no: $mediator->mediator_phone_no,
            mediator_email: $mediator->mediator_email,
            municipal_approval_date: $mediator->municipal_approval_date
        );
    }
}
