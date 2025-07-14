<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Models\Agenda;

class AgendaAdminDto
{
   public function __construct(
        public string $meeting_id,
        public string $proposal,
        public string $description,
        public string $is_final
    ){}

public static function fromLiveWireModel(Agenda $agenda):AgendaAdminDto{
    return new self(
        meeting_id: $agenda->meeting_id,
        proposal: $agenda->proposal,
        description: $agenda->description,
        is_final: $agenda->is_final
    );
}
}