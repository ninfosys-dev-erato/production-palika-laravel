<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BenefitedMemberDetailAdminDto;
use Src\Yojana\Models\BenefitedMemberDetail;

class BenefitedMemberDetailAdminService
{
public function store(BenefitedMemberDetailAdminDto $benefitedMemberDetailAdminDto){
    return BenefitedMemberDetail::create([
        'project_id' => $benefitedMemberDetailAdminDto->project_id,
        'ward_no' => $benefitedMemberDetailAdminDto->ward_no,
        'village' => $benefitedMemberDetailAdminDto->village,
        'dalit_backward_no' => $benefitedMemberDetailAdminDto->dalit_backward_no,
        'other_households_no' => $benefitedMemberDetailAdminDto->other_households_no,
        'no_of_male' => $benefitedMemberDetailAdminDto->no_of_male,
        'no_of_female' => $benefitedMemberDetailAdminDto->no_of_female,
        'no_of_others' => $benefitedMemberDetailAdminDto->no_of_others,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BenefitedMemberDetail $benefitedMemberDetail, BenefitedMemberDetailAdminDto $benefitedMemberDetailAdminDto){
    return tap($benefitedMemberDetail)->update([
        'project_id' => $benefitedMemberDetailAdminDto->project_id,
        'ward_no' => $benefitedMemberDetailAdminDto->ward_no,
        'village' => $benefitedMemberDetailAdminDto->village,
        'dalit_backward_no' => $benefitedMemberDetailAdminDto->dalit_backward_no,
        'other_households_no' => $benefitedMemberDetailAdminDto->other_households_no,
        'no_of_male' => $benefitedMemberDetailAdminDto->no_of_male,
        'no_of_female' => $benefitedMemberDetailAdminDto->no_of_female,
        'no_of_others' => $benefitedMemberDetailAdminDto->no_of_others,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BenefitedMemberDetail $benefitedMemberDetail){
    return tap($benefitedMemberDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BenefitedMemberDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


