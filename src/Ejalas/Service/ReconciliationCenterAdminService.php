<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\ReconciliationCenterAdminDto;
use Src\Ejalas\Models\ReconciliationCenter;

class ReconciliationCenterAdminService
{
public function store(ReconciliationCenterAdminDto $reconciliationCenterAdminDto){
    return ReconciliationCenter::create([
        'reconciliation_center_title' => $reconciliationCenterAdminDto->reconciliation_center_title,
        'surname' => $reconciliationCenterAdminDto->surname,
        'title' => $reconciliationCenterAdminDto->title,
        'subtile' => $reconciliationCenterAdminDto->subtile,
        'ward_id' => $reconciliationCenterAdminDto->ward_id,
        'established_date' => $reconciliationCenterAdminDto->established_date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ReconciliationCenter $reconciliationCenter, ReconciliationCenterAdminDto $reconciliationCenterAdminDto){
    return tap($reconciliationCenter)->update([
        'reconciliation_center_title' => $reconciliationCenterAdminDto->reconciliation_center_title,
        'surname' => $reconciliationCenterAdminDto->surname,
        'title' => $reconciliationCenterAdminDto->title,
        'subtile' => $reconciliationCenterAdminDto->subtile,
        'ward_id' => $reconciliationCenterAdminDto->ward_id,
        'established_date' => $reconciliationCenterAdminDto->established_date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ReconciliationCenter $reconciliationCenter){
    return tap($reconciliationCenter)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ReconciliationCenter::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


