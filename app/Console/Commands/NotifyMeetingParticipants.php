<?php

namespace App\Console\Commands;

use App\Jobs\NotifyInvitedMembersJob;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Src\Meetings\Models\Meeting;
use App\Jobs\NotifyMeetingAttendeesJob;

class NotifyMeetingParticipants extends Command
{
    protected $signature = 'app:notify-meeting-participants';
    protected $description = 'Notify participants about upcoming meetings';

    public function handle()
    {

        $meetings = Meeting::with('committee.committeeMembers', 'invitedMembers')
            ->whereDate('start_date', today()->addDays(7)->toDateString())
            ->get();

        foreach ($meetings as $meeting) {
            $message = Str::replace(['{{meeting_title}}',
                '{{state_date}}',
                '{{end_date}}',
                '{{committee_name}}'], [
                $meeting->meeting_name,
                $meeting->start_date,
                $meeting->end_date,
                $meeting->committee->committee_name,
            ], $meeting->description);

            [$committeeMembers, $invitedMembers] = self::getParticipants($meeting);
            if (!empty($committeeMembers)) {
                NotifyMeetingAttendeesJob::dispatch($committeeMembers, $message);
            }
            if (!empty($invitedMembers)) {
                NotifyMeetingAttendeesJob::dispatch($invitedMembers, $message);
            }
        }
    }

    /**
     * @param Meeting $meeting
     * @return array
     */
    public static function getParticipants(Meeting $meeting): array
    {
        return [
            $meeting->committee->committeeMembers?->whereNotNull('phone'),
            $meeting->invitedMembers?->whereNotNull('phone')
        ];
    }
}
