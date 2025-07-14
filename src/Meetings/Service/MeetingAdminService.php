<?php

namespace Src\Meetings\Service;

use App\Console\Commands\NotifyMeetingParticipants;
use App\Jobs\CreateRecurringMeetingsJob;
use App\Jobs\NotifyMeetingAttendeesJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Src\Meetings\DTO\MeetingAdminDto;
use Src\Meetings\Enums\RecurrenceTypeEnum;
use Src\Meetings\Models\Meeting;

class MeetingAdminService
{
    public function store(MeetingAdminDto $meetingAdminDto)
    {
        return DB::transaction(function () use ($meetingAdminDto) {
            $initialMeeting = Meeting::create([
                'fiscal_year_id' => $meetingAdminDto->fiscal_year_id,
                'committee_id' => $meetingAdminDto->committee_id,
                'meeting_name' => $meetingAdminDto->meeting_name,
                'recurrence' => $meetingAdminDto->recurrence,
                'start_date' => $meetingAdminDto->start_date,
                'en_start_date' => $meetingAdminDto->en_start_date,
                'end_date' => $meetingAdminDto->end_date,
                'en_end_date' => $meetingAdminDto->en_end_date,
                'recurrence_end_date' => $meetingAdminDto->recurrence_end_date,
                'en_recurrence_end_date' => $meetingAdminDto->en_recurrence_end_date,
                'description' => $meetingAdminDto->description,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
            ]);

            if (!empty($meetingAdminDto->agendas)) {
                foreach ($meetingAdminDto->agendas as $agenda) {
                    $initialMeeting->agendas()->create([
                        'proposal' => $agenda['proposal'] ?? '',
                        'description' => $agenda['description'] ?? '',
                        'is_final' => $agenda['is_final'] ?? '0',
                    ]);
                }
            }

            if (!empty($meetingAdminDto->invitedMembers)) {
                foreach ($meetingAdminDto->invitedMembers as $invitedMember) {
                    $initialMeeting->invitedMembers()->create([
                        'name' => $invitedMember['name'] ?? '',
                        'designation' => $invitedMember['designation'] ?? '',
                        'phone' => $invitedMember['phone'] ?? '',
                        'email' => $invitedMember['email'] ?? '',
                    ]);
                }
            }

            if ($meetingAdminDto->recurrence == RecurrenceTypeEnum::EMERGENCY->value) {
                $this->notifyMeeting($initialMeeting);
            }

            if (!in_array($meetingAdminDto->recurrence, [RecurrenceTypeEnum::NO_RECURRENCE->value, RecurrenceTypeEnum::EMERGENCY->value])) {
                CreateRecurringMeetingsJob::dispatch($initialMeeting);
            }
            return $initialMeeting;
        });
    }


    public function update(Meeting $meeting, MeetingAdminDto $meetingAdminDto)
    {
        return DB::transaction(function () use ($meeting, $meetingAdminDto) {
            $meeting->update([
                'fiscal_year_id' => $meetingAdminDto->fiscal_year_id,
                'committee_id' => $meetingAdminDto->committee_id,
                'meeting_name' => $meetingAdminDto->meeting_name,
                'recurrence' => $meetingAdminDto->recurrence,
                'start_date' => $meetingAdminDto->start_date,
                'en_start_date' => $meetingAdminDto->en_start_date,
                'end_date' => $meetingAdminDto->end_date,
                'en_end_date' => $meetingAdminDto->en_end_date,
                'recurrence_end_date' => $meetingAdminDto->recurrence_end_date,
                'en_recurrence_end_date' => $meetingAdminDto->en_recurrence_end_date,
                'description' => $meetingAdminDto->description,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            if (!empty($meetingAdminDto->agendas)) {
                $meeting->agendas()->delete();
                foreach ($meetingAdminDto->agendas as $agenda) {
                    $meeting->agendas()->create([
                        'proposal' => $agenda['proposal'] ?? '',
                        'description' => $agenda['description'] ?? '',
                        'is_final' => $agenda['is_final'] ?? '0',
                    ]);
                }
            }

            if (!empty($meetingAdminDto->invitedMembers)) {
                $meeting->invitedMembers()->delete();
                foreach ($meetingAdminDto->invitedMembers as $invitedMember) {
                    $meeting->invitedMembers()->create([
                        'name' => $invitedMember['name'] ?? '',
                        'designation' => $invitedMember['designation'] ?? '',
                        'phone' => $invitedMember['phone'] ?? '',
                        'email' => $invitedMember['email'] ?? '',
                    ]);
                }
            }

            if ($meetingAdminDto->recurrence == RecurrenceTypeEnum::EMERGENCY->value) {
                $this->notifyMeeting($meeting);
            }

            if (!in_array($meetingAdminDto->recurrence, [RecurrenceTypeEnum::NO_RECURRENCE->value, RecurrenceTypeEnum::EMERGENCY->value])) {
                CreateRecurringMeetingsJob::dispatch($meeting);
            }

            return $meeting;
        });
    }
    
    public function delete(Meeting $meeting)
    {
        return tap($meeting)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Meeting::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    /**
     * @param Meeting $meeting
     * @return void
     */
    function notifyMeeting(Meeting $meeting): void
    {
        $message = Str::replace(['{{meeting_title}}',
            '{{state_date}}',
            '{{end_date}}',
            '{{committee_name}}'], [
            $meeting->meeting_name,
            $meeting->start_date,
            $meeting->end_date,
            $meeting->committee->committee_name,
        ], $meeting->description);

        foreach (NotifyMeetingParticipants::getParticipants($meeting) as $participant) {
            if (!empty($participant)) {
                NotifyMeetingAttendeesJob::dispatch($participant, $message);
            }
        }
    }
}


