<?php

namespace Src\Committees\DTO;

use Src\Committees\Models\CommitteeType;

class CommitteeTypeAdminDto
{
    public function __construct(
        public string $name,
        public int|string $committee_no
    ) {}

    public static function fromLiveWireModel(CommitteeType $committeeType): CommitteeTypeAdminDto
    {
        return new self(
            name: $committeeType->name,
            committee_no: $committeeType->committee_no
        );
    }
}
