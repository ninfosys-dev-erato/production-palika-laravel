<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Committee;

class CommitteeAdminDto
{
   public function __construct(
        public string $committee_type_id,
        public string $committee_name,
    ){}

public static function fromLiveWireModel(Committee $committee):CommitteeAdminDto{
    return new self(
        committee_type_id: $committee->committee_type_id,
        committee_name: $committee->committee_name,
    );
}
}
