<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Meetings\DTO\MeetingAdminDto;
use Src\Meetings\Models\Meeting;
use Src\Meetings\Service\MeetingAdminService;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Src\Settings\Models\FiscalYear;

class MeetingForm extends Component
{
    use SessionFlash, HelperDate;

    public int $step = 1;
    public $fiscalYears;
    public string $start_time;
    public string $end_time;
    public int $maxPages = 4;
    public ?Meeting $meeting;
    public array $initialMeeting = [];
    public ?Action $action;
    public  $agendas = [];
    public array $invitedMembers = [];
    public array $intersectingMeetings = [];
    public bool $intersectingMeetingsCheck = true;

    public function mount(Meeting $meeting, Action $action): void
    {
        $this->initialMeeting = $meeting->toArray();
        $this->meeting = $meeting;
        $this->action = $action;
        $this->agendas = $meeting->agendas->toArray() ?? [];
        $this->invitedMembers = $meeting->invitedMembers->toArray() ?? [];
        $startDateTime = Carbon::parse(($this->initialMeeting['en_start_date']) ?? now());
        $this->start_time = $startDateTime->toTimeString();
        $endDateTime = Carbon::parse(($this->initialMeeting['en_end_date']) ?? now());
        $this->end_time = $endDateTime->toTimeString();

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        if ($action ==  Action::CREATE) {

            $this->initialMeeting['fiscal_year_id'] = key(getSettingWithKey('fiscal-year'));
        }
    }

    protected function rules(): array
    {
        $baseRules = [
            1 => [
                'initialMeeting.fiscal_year_id' => 'required',
                'initialMeeting.committee_id' => 'required|integer|exists:met_committees,id,deleted_at,NULL',
                'initialMeeting.meeting_name' => 'required|string|max:255',
                'initialMeeting.recurrence' => 'required|string',
                'initialMeeting.start_date' => 'required|string',
                // 'initialMeeting.en_start_date' => 'required|date',
                'initialMeeting.end_date' => 'required|string',
                // 'initialMeeting.en_end_date' => 'required|date',
                'initialMeeting.recurrence_end_date' => 'required|string',
                // 'initialMeeting.en_recurrence_end_date' => 'required|date',
                'initialMeeting.description' => 'required|string',
            ],
            2 => [
                "agendas.*.proposal" => 'required|string|max:255',
                "agendas.*.description" => 'nullable|string',
                "agendas.*.is_final" => 'required|boolean',
            ],
            3 => [
                "invitedMembers.*.name" => 'required|string|max:255',
                "invitedMembers.*.designation" => 'required|string|max:255',
                "invitedMembers.*.phone" => 'required|string|max:20',
                "invitedMembers.*.email" => 'nullable|email|max:255',
            ],
        ];

        return $this->step < $this->maxPages ? $baseRules[$this->step] : array_merge($baseRules[1], $baseRules[2], $baseRules[3]);
    }

    public function messages(): array
    {
        return [
            'initialMeeting.fiscal_year_id.required' => __('The fiscal year is required.'),
            'initialMeeting.fiscal_year_id.integer' => __('The fiscal year must be an integer.'),
            'initialMeeting.fiscal_year_id.exists' => __('The selected fiscal year is invalid.'),
            'initialMeeting.committee_id.required' => __('The committee is required.'),
            'initialMeeting.committee_id.integer' => __('The committee must be an integer.'),
            'initialMeeting.committee_id.exists' => __('The selected committee is invalid.'),
            'initialMeeting.meeting_name.required' => __('The meeting name is required.'),
            'initialMeeting.meeting_name.string' => __('The meeting name must be a string.'),
            'initialMeeting.meeting_name.max' => __('The meeting name must not exceed 255 characters.'),
            'initialMeeting.recurrence.required' => __('The recurrence is required.'),
            'initialMeeting.recurrence.string' => __('The recurrence must be a string.'),
            'initialMeeting.start_date.required' => __('The start date is required.'),
            'initialMeeting.end_date.required' => __('The end date is required.'),
            'initialMeeting.recurrence_end_date.required' => __('The recurrence end date is required.'),
            'initialMeeting.description.required' => __('The description is required.'),
            'initialMeeting.description.string' => __('The description must be a string.'),
            'agendas.*.proposal.required' => __('The agenda proposal is required.'),
            'agendas.*.proposal.string' => __('The agenda proposal must be a string.'),
            'agendas.*.proposal.max' => __('The agenda proposal must not exceed 255 characters.'),
            'agendas.*.description.string' => __('The agenda description must be a string.'),
            'agendas.*.is_final.required' => __('The final status of the agenda is required.'),
            'agendas.*.is_final.boolean' => __('The final status must be true or false.'),
            'invitedMembers.*.name.required' => __('The invited member name is required.'),
            'invitedMembers.*.name.string' => __('The invited member name must be a string.'),
            'invitedMembers.*.name.max' => __('The invited member name must not exceed 255 characters.'),
            'invitedMembers.*.designation.required' => __('The invited member designation is required.'),
            'invitedMembers.*.designation.string' => __('The invited member designation must be a string.'),
            'invitedMembers.*.designation.max' => __('The invited member designation must not exceed 255 characters.'),
            'invitedMembers.*.phone.required' => __('The invited member phone is required.'),
            'invitedMembers.*.phone.string' => __('The invited member phone must be a string.'),
            'invitedMembers.*.phone.max' => __('The invited member phone must not exceed 20 characters.'),
            'invitedMembers.*.email.required' => __('The invited member email is required.'),
            'invitedMembers.*.email.email' => __('The invited member email must be a valid email address.'),
            'invitedMembers.*.email.max' => __('The invited member email must not exceed 255 characters.'),
        ];
    }
    public function addAgenda(): void
    {
        $this->agendas[] = ['proposal' => '', 'description' => '', 'is_final' => 0];
    }

    public function removeAgenda(int $index): void
    {
        if (isset($this->agendas[$index])) {
            unset($this->agendas[$index]);
            $this->agendas = array_values($this->agendas);
        }
    }


    #[On('search-user')]
    public function restructureData(array $result)
    {

        $this->invitedMembers[] = [
            'name' => $result['name'],
            'designation' => '',
            'phone' => $result['mobile_no'],
            'email' => $result['email']
        ];
    }

    public function addInvitedMember(): void
    {
        $this->invitedMembers[] = ['name' => '', 'designation' => '', 'phone' => '', 'email' => ''];
    }

    public function removeInvitedMember(int $index): void
    {
        if (isset($this->invitedMembers[$index])) {
            unset($this->invitedMembers[$index]);
            $this->invitedMembers = array_values($this->invitedMembers);
        }
    }

    public function nextPage(): void
    {
        $this->validate();

        if ($this->step === 1 && !$this->validateRecurrenceDates()) {
            return;
        }

        if ($this->step < $this->maxPages) {
            if ($this->step === 3 && !$this->handleStepThreeLogic()) {
                return;
            }

            $this->step++;
        }
    }

    private function validateRecurrenceDates(): bool
    {
        $startDateObj = new \DateTime($this->bsToAd($this->initialMeeting['start_date']));
        $endDateObj = new \DateTime($this->bsToAd($this->initialMeeting['end_date']));
        $recurrenceDateObj = new \DateTime($this->bsToAd($this->initialMeeting['recurrence_end_date']));

        if ($recurrenceDateObj < $startDateObj) {
            $this->errorFlash(__("Recurrence end date cannot be before the start date."));
            return false;
        }

        if ($endDateObj < $startDateObj) {
            $this->errorFlash(__("End date cannot be before the start date."));
            return false;
        }

        return true;
    }

    private function handleStepThreeLogic(): bool
    {
        $this->initializeDates(
            $this->initialMeeting['start_date'],
            $this->initialMeeting['end_date'],
            $this->initialMeeting['recurrence_end_date']
        );

        return $this->checkMembers();
    }



    public function previousPage(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function save()
    {
        $this->validate();
        // Convert nepali dates into english dates before saving
        $this->initializeDates($this->initialMeeting['start_date'], $this->initialMeeting['end_date'], $this->initialMeeting['recurrence_end_date']);


        // Sync agendas and invitedMembers to meeting model
        $this->initialMeeting['agendas'] = $this->agendas;
        $this->initialMeeting['invitedMembers'] = $this->invitedMembers;

        try {
            $dto = MeetingAdminDto::fromLiveWireArray($this->initialMeeting);
            $service = new MeetingAdminService();

            if ($this->action === Action::CREATE) {
                $service->store($dto);
                $this->successFlash(__("Meeting Created Successfully"));
            } elseif ($this->action === Action::UPDATE) {
                $service->update($this->meeting, $dto);
                $this->successFlash(__("Meeting Updated Successfully"));
            }

            return redirect()->route('admin.meetings.index');
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function render()
    {
        return view("Meetings::livewire.form");
    }

    private function initializeDates(string | null $meetingStartDate, string | null $meetingEndDate, string | null $recurranceEndDate)
    {
        $this->initialMeeting['en_start_date'] = $meetingStartDate != null ? $this->bsToAd($meetingStartDate) . $this->start_time : null;
        $this->initialMeeting['en_end_date'] = $meetingEndDate != null ? $this->bsToAd($meetingEndDate) . $this->end_time : null;
        $this->initialMeeting['en_recurrence_end_date'] = $recurranceEndDate != null ? $this->bsToAd($recurranceEndDate) : null;
    }

    public function checkMembers()
    {
        $givenStartDate = $this->initialMeeting['en_start_date'];
        $givenEndDate = $this->initialMeeting['en_end_date'];

        $currentMeetingMembers = collect($this->invitedMembers)->pluck('phone');

        $duplicatePhones = $currentMeetingMembers->duplicates();
        if ($duplicatePhones->isNotEmpty()) {
            $message = __("The following phone numbers are duplicated in the invited members list: ")
                . $duplicatePhones->unique()->join(', ');
            $this->errorFlash($message);
            return false;
        }

        if ($this->intersectingMeetingsCheck) {
            $this->intersectingMeetings = Meeting::where('id', '!=', $this->initialMeeting['id'] ?? 0)
                ->where(function ($query) use ($givenStartDate, $givenEndDate) {
                    $query->whereBetween('en_start_date', [$givenStartDate, $givenEndDate])
                        ->orWhereBetween('en_end_date', [$givenStartDate, $givenEndDate])
                        ->orWhere(function ($q) use ($givenStartDate, $givenEndDate) {
                            $q->where('en_start_date', '<=', $givenStartDate)
                                ->where('en_end_date', '>=', $givenEndDate);
                        });
                })
                ->whereHas('invitedMembers', function ($query) use ($currentMeetingMembers) {
                    $query->whereIn('phone', $currentMeetingMembers);
                })
                ->pluck('id')
                ->toArray();

            if (!empty($this->intersectingMeetings)) {
                $conflictingMembers = collect($this->invitedMembers)
                    ->whereIn('phone', $currentMeetingMembers->toArray());

                if ($conflictingMembers->isNotEmpty()) {
                    $names = $conflictingMembers->pluck('name')->join(', ');
                    $this->errorFlash(__("The following members are already in another meeting: {$names}"));
                    return false;
                }
            }
        }
        return true;
    }
}
