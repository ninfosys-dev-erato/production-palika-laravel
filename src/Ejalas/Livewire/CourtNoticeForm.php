<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\CourtNoticeAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Models\CourtNotice;
use Src\Ejalas\Service\CourtNoticeAdminService;
use Src\Settings\Models\FiscalYear;

class CourtNoticeForm extends Component
{
    use SessionFlash, HelperDate;

    public ?CourtNotice $courtNotice;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $reconciliationCenters;
    public $fiscalYears;
    public $showCourtNoticeForm = false;

    protected $listeners = ['edit-courtNotice' => 'editCourtNotice'];

    public function rules(): array
    {
        return [
            'courtNotice.notice_no' => ['required'],
            'courtNotice.fiscal_year_id' => ['required'],
            'courtNotice.complaint_registration_id' => ['required'],
            'courtNotice.reference_no' => ['nullable'],
            'courtNotice.notice_date' => ['required'],
            'courtNotice.notice_time' => ['required'],
            'courtNotice.reconciliation_center_id' => ['required'],
        ];
    }

    public function mount($complaintRegistration, ?CourtNotice $courtNotice = null)
    {
        $this->complaintRegistration = $complaintRegistration;

       
        $this->courtNotice = $courtNotice ?? $this->getDefaultCourtNotice();

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('title','id');
    }

    public function render()
    {
        return view("Ejalas::livewire.court-notice.form");
    }

    public function toggleCourtNoticeForm()
    {
        $this->showCourtNoticeForm = !$this->showCourtNoticeForm;

        if ($this->showCourtNoticeForm) {
            $this->resetForm(); // fresh form when opening
        }

        $this->dispatch('init-registration-date');
    }


public function save()
{
    $this->validate();

    try {
        $dto = CourtNoticeAdminDto::fromLiveWireModel($this->courtNotice);
        $service = new CourtNoticeAdminService();
  
        switch ($this->action) {
            case Action::CREATE:
       
                $service->store($dto);
                $this->successToast(__('ejalas::ejalas.court_notice_created_successfully'));
                break;

            case Action::UPDATE:
                $service->update($this->courtNotice, $dto);
                $this->successToast(__('ejalas::ejalas.court_notice_updated_successfully'));
                break;

            default:
                $this->errorFlash(__('ejalas::ejalas.invalid_action'));
                break;
        }

        $this->showCourtNoticeForm = false;
        $this->resetForm(); // reset for next creation

    } catch (\Throwable $e) {
        logger($e->getMessage());
        $this->errorFlash('Something went wrong while saving. ' . $e->getMessage());
    }
}



    public function editCourtNotice(CourtNotice $courtNotice)
    {
        $this->courtNotice = $courtNotice;
        $this->action = Action::UPDATE;
        $this->showCourtNoticeForm = true;
        $this->dispatch('init-registration-date');
    }

 
    protected function resetForm()
    {
        $this->courtNotice = $this->getDefaultCourtNotice();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultCourtNotice(): CourtNotice
    {
        $courtNotice = new CourtNotice();
        $courtNotice->complaint_registration_id = $this->complaintRegistration->id;
        $courtNotice->notice_no = CourtNotice::max('id') + 1;
        $courtNotice->notice_time = now()->format('H:i');

        return $courtNotice;
    }
}
