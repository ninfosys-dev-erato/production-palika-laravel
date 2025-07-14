<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\MaterialCollectionAdminDto;
use Src\Yojana\Models\MaterialCollection;

class MaterialCollectionAdminService
{
public function store(MaterialCollectionAdminDto $materialCollectionAdminDto){
    return MaterialCollection::create([
        'material_rate_id' => $materialCollectionAdminDto->material_rate_id,
        'unit_id' => $materialCollectionAdminDto->unit_id,
        'activity_no' => $materialCollectionAdminDto->activity_no,
        'remarks' => $materialCollectionAdminDto->remarks,
        'fiscal_year_id' => $materialCollectionAdminDto->fiscal_year_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MaterialCollection $materialCollection, MaterialCollectionAdminDto $materialCollectionAdminDto){
    return tap($materialCollection)->update([
        'material_rate_id' => $materialCollectionAdminDto->material_rate_id,
        'unit_id' => $materialCollectionAdminDto->unit_id,
        'activity_no' => $materialCollectionAdminDto->activity_no,
        'remarks' => $materialCollectionAdminDto->remarks,
        'fiscal_year_id' => $materialCollectionAdminDto->fiscal_year_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MaterialCollection $materialCollection){
    return tap($materialCollection)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MaterialCollection::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


