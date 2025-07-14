<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\RegistrationIndicator;

class RegistrationIndicatorAdminDto
{
   public function __construct(
        public string $dispute_title,
        public string $indicator_type
    ){}

public static function fromLiveWireModel(RegistrationIndicator $registrationIndicator):RegistrationIndicatorAdminDto{
    return new self(
        dispute_title: $registrationIndicator->dispute_title,
        indicator_type: $registrationIndicator->indicator_type
    );
}
}
