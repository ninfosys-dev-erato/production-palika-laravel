<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\NatureOfBusiness;

class NatureOfBusinessAdminDto
{
    public function __construct(
        public string $title,
        public string $title_ne,
    )
    {
    }

    public static function fromLiveWireModel(NatureOfBusiness $natureOfBusiness)
    {
        return new self(
            title: $natureOfBusiness->title,
            title_ne: $natureOfBusiness->title_ne,
        );
    }
}
