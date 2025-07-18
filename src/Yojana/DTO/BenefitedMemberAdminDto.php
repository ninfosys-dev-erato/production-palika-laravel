<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BenefitedMember;

class BenefitedMemberAdminDto
{
    public function __construct(
        public string $title,
        public ?bool $is_population
    ) {}

    public static function fromLiveWireModel(BenefitedMember $benefitedMember): BenefitedMemberAdminDto
    {
        return new self(
            title: $benefitedMember->title,
            is_population: $benefitedMember->is_population ?? false
        );
    }
}
