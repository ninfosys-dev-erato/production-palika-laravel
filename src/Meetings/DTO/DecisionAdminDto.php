<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Models\Decision;

class DecisionAdminDto
{
   public function __construct(
        public string $meeting_id,
        public string $date,
        public string $chairman,
        public string $en_date,
        public string $description,
    ){}

public static function fromLiveWireModel(Decision $decision):DecisionAdminDto{
    return new self(
        meeting_id: $decision->meeting_id,
        date: $decision->date,
        chairman: $decision->chairman,
        en_date: $decision->en_date,
        description: $decision->description,
    );
}
}