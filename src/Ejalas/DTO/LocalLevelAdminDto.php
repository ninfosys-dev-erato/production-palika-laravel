<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\LocalLevel;

class LocalLevelAdminDto
{
    public function __construct(
        public string $title,
        public string $short_title,
        public string $type,
        public string $province_id,
        public string $district_id,
        public string $local_body_id,
        public ?string $mobile_no,
        public ?string $email,
        public ?string $website,
        public ?string $position
    ) {}

    public static function fromLiveWireModel(LocalLevel $localLevel): LocalLevelAdminDto
    {
        return new self(
            title: $localLevel->title,
            short_title: $localLevel->short_title,
            type: $localLevel->type,
            province_id: $localLevel->province_id,
            district_id: $localLevel->district_id,
            local_body_id: $localLevel->local_body_id,
            mobile_no: $localLevel->mobile_no,
            email: $localLevel->email,
            website: $localLevel->website,
            position: $localLevel->position
        );
    }
}
