<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\HearingScheduleAdminDto;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\HearingSchedule;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\HearingScheduleAdminService;
use Src\FiscalYears\Models\FiscalYear;

class HearingScheduleForm extends Component
{
    use SessionFlash, HelperDate;

    public ?HearingSchedule $hearingSchedule;
    public ?Action $action;
    public $complainRegistrations;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $reconciliationCenters;
    public $fiscalYears;
    public $from;


    public function rules(): array
    {
        return [
            'hearingSchedule.hearing_paper_no' => ['required'],
            'hearingSchedule.fiscal_year_id' => ['required'],
            'hearingSchedule.hearing_date' => ['required'],
            'hearingSchedule.hearing_time' => ['required'],
            'hearingSchedule.reference_no' => ['nullable'],
            'hearingSchedule.reconciliation_center_id' => ['required'],
            'hearingSchedule.complaint_registration_id' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.hearing-schedule.form");
    }

    public function mount(HearingSchedule $hearingSchedule, Action $action, $from)
    {
        $this->hearingSchedule = $hearingSchedule;
        $this->action = $action;
        $this->from = $from;

        $nextId = HearingSchedule::max('id') + 1;

        // $this->hearingSchedule->fiscal_year_id = getSetting('fiscal-year');
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->hearingSchedule->hearing_time = now()->format('H:i');
        $this->hearingSchedule->hearing_paper_no = $nextId;

        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });

        $this->reconciliationCenters = PlaceOfRegistration::getForWeb();


        if ($this->hearingSchedule->complaint_registration_id) {
            $this->getComplaintRegistration();
            $this->hearingSchedule->hearing_date = replaceNumbers($this->adToBs($this->hearingSchedule->hearing_date), true);
        }
    }

    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->hearingSchedule['complaint_registration_id'];
        $this->complaintData = ComplaintRegistration::with([
            'fiscalYear',
            'priority',
            'disputeMatter',
            'parties'
        ])->find($complaintRegistrationId)?->toArray() ?? [];

        if (!empty($this->complaintData)) {
            // Access parties through the relationship
            $parties = collect($this->complaintData['parties'] ?? []);

            // Separate complainers and defenders using pivot data
            $this->complainers = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Complainer';
            })->pluck('name')->toArray();

            $this->defenders = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Defender';
            })->pluck('name')->toArray();
        } else {
            $this->complainers = [];
            $this->defenders = [];
        }
        if ($this->action  == Action::CREATE) {
            $count = HearingSchedule::where('complaint_registration_id', $complaintRegistrationId)->count();
            $this->hearingSchedule['reference_no'] = $count + 1;
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->hearingSchedule['hearing_date']);
            $this->hearingSchedule['hearing_date'] = $englishDate;
            $dto = HearingScheduleAdminDto::fromLiveWireModel($this->hearingSchedule);
            $service = new HearingScheduleAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.hearing_schedule_created_successfully'));
                    return redirect()->route('admin.ejalas.hearing_schedules.index', ['from' => $this->from]);
                    break;
                case Action::UPDATE:
                    $service->update($this->hearingSchedule, $dto);
                    $this->successFlash(__('ejalas::ejalas.hearing_schedule_updated_successfully'));
                    return redirect()->route('admin.ejalas.hearing_schedules.index', ['from' => $this->from]);
                    break;
                default:
                    return redirect()->route('admin.ejalas.hearing_schedules.index', ['from' => $this->from]);
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
