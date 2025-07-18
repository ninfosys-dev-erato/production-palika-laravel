<?php

namespace Src\DigitalBoard\DTO;

use Src\DigitalBoard\Models\CitizenCharter;

class CitizenCharterAdminDto
{
    public function __construct(
        public ?string $branch_id,
        public string $service,
        public string $required_document,
        public ?string $amount,
        public string $time,
        public ?string $responsible_person,
        public bool $can_show_on_admin
    ) {}

    public static function fromLiveWireModel(CitizenCharter $citizenCharter): CitizenCharterAdminDto
    {
        return new self(
            branch_id: $citizenCharter->branch_id ?? null,
            service: $citizenCharter->service,
            required_document: $citizenCharter->required_document,
            amount: $citizenCharter->amount,
            time: $citizenCharter->time,
            responsible_person: $citizenCharter->responsible_person ?? null,
            can_show_on_admin: $citizenCharter->can_show_on_admin
        );
    }
}
