<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Anusuchi;

class AnusuchiAdminDto
{
   public function __construct(
        public ?string $name,
        public ?string $date,
        public ?string $name_en,
        public ?string $description
    ){}

public static function fromLiveWireModel(Anusuchi $anusuchi):AnusuchiAdminDto{
    return new self(
        name: $anusuchi->name,
        date: $anusuchi->date ?? null,
        name_en: $anusuchi->name_en,
        description: $anusuchi->description
    );
}
}
