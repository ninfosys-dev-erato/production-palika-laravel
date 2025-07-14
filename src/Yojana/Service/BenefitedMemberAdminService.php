<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BenefitedMemberAdminDto;
use Src\Yojana\Models\BenefitedMember;

class BenefitedMemberAdminService
{
public function store(BenefitedMemberAdminDto $benefitedMemberAdminDto){
    return BenefitedMember::create([
        'title' => $benefitedMemberAdminDto->title,
        'is_population' => $benefitedMemberAdminDto->is_population,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BenefitedMember $benefitedMember, BenefitedMemberAdminDto $benefitedMemberAdminDto){
    return tap($benefitedMember)->update([
        'title' => $benefitedMemberAdminDto->title,
        'is_population' => $benefitedMemberAdminDto->is_population,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BenefitedMember $benefitedMember){
    return tap($benefitedMember)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BenefitedMember::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


