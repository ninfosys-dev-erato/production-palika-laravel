<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BenefitedMemberDetail;

class BenefitedMemberDetailAdminDto
{
   public function __construct(
        public string $project_id,
        public string $ward_no,
        public string $village,
        public string $dalit_backward_no,
        public string $other_households_no,
        public string $no_of_male,
        public string $no_of_female,
        public string $no_of_others
    ){}

public static function fromLiveWireModel(BenefitedMemberDetail $benefitedMemberDetail):BenefitedMemberDetailAdminDto{
    return new self(
        project_id: $benefitedMemberDetail->project_id,
        ward_no: $benefitedMemberDetail->ward_no,
        village: $benefitedMemberDetail->village,
        dalit_backward_no: $benefitedMemberDetail->dalit_backward_no,
        other_households_no: $benefitedMemberDetail->other_households_no,
        no_of_male: $benefitedMemberDetail->no_of_male,
        no_of_female: $benefitedMemberDetail->no_of_female,
        no_of_others: $benefitedMemberDetail->no_of_others
    );
}
}
