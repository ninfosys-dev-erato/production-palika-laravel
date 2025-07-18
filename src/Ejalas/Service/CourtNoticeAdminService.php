<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\CourtNoticeAdminDto;
use Src\Ejalas\Models\CourtNotice;

class CourtNoticeAdminService
{
public function store(CourtNoticeAdminDto $courtNoticeAdminDto){
    return CourtNotice::create([
        'notice_no' => $courtNoticeAdminDto->notice_no,
        'fiscal_year_id' => $courtNoticeAdminDto->fiscal_year_id,
        'complaint_registration_id' => $courtNoticeAdminDto->complaint_registration_id,
        'reference_no' => $courtNoticeAdminDto->reference_no,
        'notice_date' => $courtNoticeAdminDto->notice_date,
        'notice_time' => $courtNoticeAdminDto->notice_time,
        'reconciliation_center_id' => $courtNoticeAdminDto->reconciliation_center_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CourtNotice $courtNotice, CourtNoticeAdminDto $courtNoticeAdminDto){
    return tap($courtNotice)->update([
        'notice_no' => $courtNoticeAdminDto->notice_no,
        'fiscal_year_id' => $courtNoticeAdminDto->fiscal_year_id,
        'complaint_registration_id' => $courtNoticeAdminDto->complaint_registration_id,
        'reference_no' => $courtNoticeAdminDto->reference_no,
        'notice_date' => $courtNoticeAdminDto->notice_date,
        'notice_time' => $courtNoticeAdminDto->notice_time,
        'reconciliation_center_id' => $courtNoticeAdminDto->reconciliation_center_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CourtNotice $courtNotice){
    return tap($courtNotice)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CourtNotice::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


