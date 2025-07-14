<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\GrantOffice;

class GrantOfficeAdminDto
{
   public function __construct(
        public string $office_name,
        public string $office_name_en
    ){}

public static function fromLiveWireModel(GrantOffice $grantOffice):GrantOfficeAdminDto{
    return new self(
        office_name: $grantOffice->office_name,
        office_name_en: $grantOffice->office_name_en
    );
}
}
