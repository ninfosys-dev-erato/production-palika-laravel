<?php

namespace Src\Grievance\DTO;

use Src\Grievance\Models\GrievanceType;

class GrievanceTypeAdminDto
{
    public function __construct(
        public string $title,
        public ?bool $is_ward,
    ) {}

    public static function fromLiveWireModel(GrievanceType $grievanceType): GrievanceTypeAdminDto
    {
        return new self(
            title: $grievanceType->title,
            is_ward: $grievanceType?->is_ward ?? false,
        );
    }
}
