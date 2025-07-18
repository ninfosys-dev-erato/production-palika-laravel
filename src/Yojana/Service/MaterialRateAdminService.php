<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\MaterialRateAdminDto;
use Src\Yojana\Models\MaterialRate;

class MaterialRateAdminService
{
public function store(MaterialRateAdminDto $materialRateAdminDto){
    return MaterialRate::create([
        'material_id' => $materialRateAdminDto->material_id,
        'fiscal_year_id' => $materialRateAdminDto->fiscal_year_id,
        'is_vat_included' => $materialRateAdminDto->is_vat_included,
        'is_vat_needed' => $materialRateAdminDto->is_vat_needed,
        'referance_no' => $materialRateAdminDto->referance_no,
        'royalty' => $materialRateAdminDto->royalty,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MaterialRate $materialRate, MaterialRateAdminDto $materialRateAdminDto){
    return tap($materialRate)->update([
        'material_id' => $materialRateAdminDto->material_id,
        'fiscal_year_id' => $materialRateAdminDto->fiscal_year_id,
        'is_vat_included' => $materialRateAdminDto->is_vat_included,
        'is_vat_needed' => $materialRateAdminDto->is_vat_needed,
        'referance_no' => $materialRateAdminDto->referance_no,
        'royalty' => $materialRateAdminDto->royalty,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MaterialRate $materialRate){
    return tap($materialRate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MaterialRate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


