<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\HearingScheduleAdminDto;
use Src\Ejalas\Models\HearingSchedule;

class HearingScheduleAdminService
{
    public function store(HearingScheduleAdminDto $hearingScheduleAdminDto)
    {
        return HearingSchedule::create([
            'hearing_paper_no' => $hearingScheduleAdminDto->hearing_paper_no,
            'fiscal_year_id' => $hearingScheduleAdminDto->fiscal_year_id,
            'complaint_registration_id' => $hearingScheduleAdminDto->complaint_registration_id,
            'hearing_date' => $hearingScheduleAdminDto->hearing_date,
            'hearing_time' => $hearingScheduleAdminDto->hearing_time,
            'reference_no' => $hearingScheduleAdminDto->reference_no,
            'reconciliation_center_id' => $hearingScheduleAdminDto->reconciliation_center_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(HearingSchedule $hearingSchedule, HearingScheduleAdminDto $hearingScheduleAdminDto)
    {
        return tap($hearingSchedule)->update([
            'hearing_paper_no' => $hearingScheduleAdminDto->hearing_paper_no,
            'fiscal_year_id' => $hearingScheduleAdminDto->fiscal_year_id,
            'complaint_registration_id' => $hearingScheduleAdminDto->complaint_registration_id,
            'hearing_date' => $hearingScheduleAdminDto->hearing_date,
            'hearing_time' => $hearingScheduleAdminDto->hearing_time,
            'reference_no' => $hearingScheduleAdminDto->reference_no,
            'reconciliation_center_id' => $hearingScheduleAdminDto->reconciliation_center_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(HearingSchedule $hearingSchedule)
    {
        return tap($hearingSchedule)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        HearingSchedule::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
