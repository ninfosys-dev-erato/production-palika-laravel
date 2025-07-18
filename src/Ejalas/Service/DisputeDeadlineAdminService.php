<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\DisputeDeadlineAdminDto;
use Src\Ejalas\Models\DisputeDeadline;

class DisputeDeadlineAdminService
{
public function store(DisputeDeadlineAdminDto $disputeDeadlineAdminDto){
    return DisputeDeadline::create([
        'complaint_registration_id' => $disputeDeadlineAdminDto->complaint_registration_id,
        'registrar_id' => $disputeDeadlineAdminDto->registrar_id,
        'deadline_set_date' => $disputeDeadlineAdminDto->deadline_set_date,
        'deadline_extension_period' => $disputeDeadlineAdminDto->deadline_extension_period,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(DisputeDeadline $disputeDeadline, DisputeDeadlineAdminDto $disputeDeadlineAdminDto){
    return tap($disputeDeadline)->update([
        'complaint_registration_id' => $disputeDeadlineAdminDto->complaint_registration_id,
        'registrar_id' => $disputeDeadlineAdminDto->registrar_id,
        'deadline_set_date' => $disputeDeadlineAdminDto->deadline_set_date,
        'deadline_extension_period' => $disputeDeadlineAdminDto->deadline_extension_period,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(DisputeDeadline $disputeDeadline){
    return tap($disputeDeadline)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    DisputeDeadline::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


