<?php

namespace Src\Grievance\DTO;

use Src\Grievance\Models\GrievanceType;

class GrievanceTypeAdminDto
{
    public function __construct(
        public string $title,

    )
    {
    }

    public static function fromLiveWireModel(GrievanceType $grievanceType): GrievanceTypeAdminDto
    {
        return new self(
            title: $grievanceType->title,
        );
    }
}
