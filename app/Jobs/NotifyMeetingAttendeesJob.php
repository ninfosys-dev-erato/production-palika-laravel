<?php

namespace App\Jobs;

use App\Console\Commands\NotifyMeetingParticipants;
use App\Notifications\MeetingScheduleNotification;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyMeetingAttendeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $participants;
    protected string $message;


    public function __construct(mixed $participants, string $message)
    {
        $this->participants = $participants;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       foreach ($this->participants as $participant) {
           $participant->notify(new MeetingScheduleNotification($this->message));
       }
    }
}

