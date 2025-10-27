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
    public ?Action $action =Action::CREATE;
    public $complaintRegistration;
    public $reconciliationCenters;
    public $fiscalYears;
    public $hearingScheduleForm = false;

       protected $listeners = ['edit-hearingSchedule' => 'editHearingSchedule'];


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

    public function mount($complaintRegistration, HearingSchedule $hearingSchedule)
    {
        $this->complaintRegistration = $complaintRegistration;
   
        $this->hearingSchedule = $hearingSchedule ?? $this->getDefaultHearingSchedule();
        

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');


        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('title','id');
    }

       public function toggleHearingScheduleForm()
    {
        $this->hearingScheduleForm = !$this->hearingScheduleForm;

        if ($this->hearingScheduleForm) {
            $this->resetForm(); // fresh form when opening
        }

        $this->dispatch('init-registration-date');
    }

    public function save()
    {
      
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->hearingSchedule['hearing_date']);
            $this->hearingSchedule['hearing_date_en'] = $englishDate;
            $dto = HearingScheduleAdminDto::fromLiveWireModel($this->hearingSchedule);
         
            $service = new HearingScheduleAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.hearing_schedule_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->hearingSchedule, $dto);
                    $this->successToast(__('ejalas::ejalas.hearing_schedule_updated_successfully'));
                    break;
                default:
                    break;
            }
            
        $this->hearingScheduleForm = false;
        $this->resetForm(); 
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    
    public function editHearingSchedule(HearingSchedule $hearingSchedule)
    {
        $this->hearingSchedule = $hearingSchedule;
        $this->action = Action::UPDATE;
        $this->hearingScheduleForm = true;
        $this->dispatch('init-registration-date');
    }

 
    protected function resetForm()
    {
        $this->hearingSchedule = $this->getDefaultHearingSchedule();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultHearingSchedule(): HearingSchedule
    {
        $hearingSchedule = new HearingSchedule();
        $hearingSchedule->complaint_registration_id = $this->complaintRegistration->id;
        $hearingSchedule->hearing_paper_no = HearingSchedule::max('id') + 1;
        $hearingSchedule->hearing_time = now()->format('H:i');

        return $hearingSchedule;
    }
}
