<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\WitnessesRepresentative;

class WitnessesRepresentativeAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $name,
        public string $address,
        public bool $is_first_party
    ) {}

    public static function fromLiveWireModel(WitnessesRepresentative $witnessesRepresentative): WitnessesRepresentativeAdminDto
    {
        return new self(
            complaint_registration_id: $witnessesRepresentative->complaint_registration_id,
            name: $witnessesRepresentative->name,
            address: $witnessesRepresentative->address,
            is_first_party: $witnessesRepresentative->is_first_party ?? false
        );
    }
}
