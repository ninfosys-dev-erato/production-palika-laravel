<?php

namespace Src\DigitalBoard\DTO;

use Src\DigitalBoard\Models\Program;

class ProgramAdminDto
{
    public function __construct(
        public string $title,
        public string $photo,
        public bool $can_show_on_admin
    ) {}

    public static function fromLiveWireModel(Program $program): ProgramAdminDto
    {
        return new self(
            title: $program->title,
            photo: $program->photo,
            can_show_on_admin: $program->can_show_on_admin
        );
    }
}
