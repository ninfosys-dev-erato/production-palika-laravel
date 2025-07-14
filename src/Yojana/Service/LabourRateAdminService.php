<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\LabourRateAdminDto;
use Src\Yojana\Models\LabourRate;

class LabourRateAdminService
{
public function store(LabourRateAdminDto $labourRateAdminDto){
    return LabourRate::create([
        'fiscal_year_id' => $labourRateAdminDto->fiscal_year_id,
        'labour_id' => $labourRateAdminDto->labour_id,
        'rate' => $labourRateAdminDto->rate,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LabourRate $labourRate, LabourRateAdminDto $labourRateAdminDto){
    return tap($labourRate)->update([
        'fiscal_year_id' => $labourRateAdminDto->fiscal_year_id,
        'labour_id' => $labourRateAdminDto->labour_id,
        'rate' => $labourRateAdminDto->rate,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LabourRate $labourRate){
    return tap($labourRate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LabourRate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


