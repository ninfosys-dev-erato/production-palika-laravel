<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Src\Meetings\Enums\RecurrenceTypeEnum;
use Src\Meetings\Models\Meeting;

class CreateRecurringMeetingsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Meeting $meetingData;

    /**
     * Create a new job instance.
     *
     * @param Meeting $meetingData
     */
    public function __construct(Meeting $meetingData)
    {
        $this->meetingData = $meetingData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $originalStartDate = Carbon::parse($this->meetingData->start_date);
        $originalEndDate = Carbon::parse($this->meetingData->end_date);
        $recurrenceEndDate = Carbon::parse($this->meetingData->recurrence_end_date);
        $recurrence = $this->meetingData->recurrence;

        $interval = match ($recurrence) {
            RecurrenceTypeEnum::WEEKLY => '1 week',
            RecurrenceTypeEnum::MONTHLY => '1 month',
            RecurrenceTypeEnum::YEARLY => '1 year',
            default => null,
        };

        if ($interval) {
            $originalStartDate->add($interval);
            $originalEndDate->add($interval);
        }


        while ($originalStartDate->lte($recurrenceEndDate)) {
            // Clone the dates for each iteration
            $currentStartDate = $originalStartDate->copy();
            $currentEndDate = $originalEndDate->copy();

            // Adjust start and end dates if they fall on Saturday
            if ($currentStartDate->isSaturday()) {
                $currentStartDate->addDay(); // Move to Sunday
            }

            if ($currentEndDate->isSaturday()) {
                $currentEndDate->addDay();
            }

            // Collect meeting data for bulk insertion
            Meeting::create( [
                'fiscal_year_id' => $this->meetingData->fiscal_year_id,
                'committee_id' => $this->meetingData->committee_id,
                'meeting_name' => $this->meetingData->meeting_name,
                'recurrence' => $recurrence,
                'start_date' => $currentStartDate->toDateString(),
                'end_date' => $currentEndDate->toDateString(),
                'recurrence_end_date' => $recurrenceEndDate->toDateString(),
                'description' => $this->meetingData->description,
                'created_by' => $this->meetingData->created_by,
                'meeting_id' => $this->meetingData->id,
            ]);

            // Move to the next date based on recurrence interval
            if ($interval) {
                $originalStartDate->add($interval);
                $originalEndDate->add($interval);
            } else {
                break;
            }
        }
    }

}
