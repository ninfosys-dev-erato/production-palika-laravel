<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Criterion;

class CriterionAdminDto
{
   public function __construct(
        public ?int $anusuchi_id,
        public ?string $name,
        public ?string $name_en,
        public ?string $max_score,
        public ?string $min_score
    ){}

public static function fromLiveWireModel(Criterion $criterion):CriterionAdminDto{
    return new self(
        anusuchi_id: $criterion->anusuchi_id,
        name: $criterion->name,
        name_en: $criterion->name_en,
        max_score: $criterion->max_score,
        min_score: $criterion->min_score
    );
}

public static function fromArray(array $data): self
{
    return new self(
        $data['anusuchi_id'],
        $data['name'],
        $data['name_en'],
        $data['max_score'],
        $data['min_score'],
    );
}
}
