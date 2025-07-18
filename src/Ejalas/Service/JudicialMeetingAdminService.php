<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\JudicialMeetingAdminDto;
use Src\Ejalas\Models\JudicialMeeting;

class JudicialMeetingAdminService
{
    public function store(JudicialMeetingAdminDto $judicialMeetingAdminDto)
    {
        return JudicialMeeting::create([
            'fiscal_year_id' => $judicialMeetingAdminDto->fiscal_year_id,
            'meeting_date' => $judicialMeetingAdminDto->meeting_date,
            'meeting_time' => $judicialMeetingAdminDto->meeting_time,
            'meeting_number' => $judicialMeetingAdminDto->meeting_number,
            'decision_number' => $judicialMeetingAdminDto->decision_number,
            'invited_employee_id' => $judicialMeetingAdminDto->invited_employee_id,
            'members_present_id' => $judicialMeetingAdminDto->members_present_id,
            'meeting_topic' => $judicialMeetingAdminDto->meeting_topic,
            'decision_details' => $judicialMeetingAdminDto->decision_details,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(JudicialMeeting $judicialMeeting, JudicialMeetingAdminDto $judicialMeetingAdminDto)
    {
        return tap($judicialMeeting)->update([
            'fiscal_year_id' => $judicialMeetingAdminDto->fiscal_year_id,
            'meeting_date' => $judicialMeetingAdminDto->meeting_date,
            'meeting_time' => $judicialMeetingAdminDto->meeting_time,
            'meeting_number' => $judicialMeetingAdminDto->meeting_number,
            'decision_number' => $judicialMeetingAdminDto->decision_number,
            'invited_employee_id' => $judicialMeetingAdminDto->invited_employee_id,
            'members_present_id' => $judicialMeetingAdminDto->members_present_id,
            'meeting_topic' => $judicialMeetingAdminDto->meeting_topic,
            'decision_details' => $judicialMeetingAdminDto->decision_details,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(JudicialMeeting $judicialMeeting)
    {
        return tap($judicialMeeting)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        JudicialMeeting::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
