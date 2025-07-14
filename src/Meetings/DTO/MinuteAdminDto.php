<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Models\Minute;

class MinuteAdminDto
{
   public function __construct(
        public string $description,
        public int $meeting_id
    ){}

    public static function fromLiveWireModel(Minute $minute):MinuteAdminDto{
        return new self(
            description: $minute->description,
            meeting_id: $minute->meeting_id
        );
    }
}