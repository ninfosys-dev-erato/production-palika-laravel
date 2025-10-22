<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\DisputeDeadlineAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeDeadline;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Service\DisputeDeadlineAdminService;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;

class DisputeDeadlineForm extends Component
{
    use SessionFlash, HelperDate;


    public ?DisputeDeadline $disputeDeadline;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $registerEmployees;
    public $showDisputeDeadlineForm = false;

      protected $listeners = ['edit-disputeDeadline' => 'editDisputeDeadline'];

    public function rules(): array
    {
        return [
            'disputeDeadline.complaint_registration_id' => ['required'],
            'disputeDeadline.registrar_id' => ['required'],
            'disputeDeadline.deadline_set_date' => ['required'],
            'disputeDeadline.deadline_extension_period' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.dispute-deadline.form");
    }

    public function mount(ComplaintRegistration $complaintRegistration, DisputeDeadline $disputeDeadline)
    {

        $this->complaintRegistration = $complaintRegistration;

        $this->disputeDeadline = $disputeDeadline;

        $this->disputeDeadline->complaint_registration_id = $complaintRegistration->id;
        
 



        $this->registerEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');

    }



    public function toggleDisputeDeadlineForm(){
       $this->showDisputeDeadlineForm = !$this->showDisputeDeadlineForm;
         $this->dispatch('init-registration-date');
             if ($this->showDisputeDeadlineForm) {
       $this->resetForm();
    }
    }

    public function save()
    {
        $this->validate();
        try {
            $bsDate = $this->disputeDeadline['deadline_set_date'];
            $englishDate = $this->bsToAd($bsDate);
            $this->disputeDeadline['deadline_set_date_en'] = $englishDate;

            $dto = DisputeDeadlineAdminDto::fromLiveWireModel($this->disputeDeadline);
            $service = new DisputeDeadlineAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.dispute_deadline_created_successfully'));
                    $this->showDisputeDeadlineForm = false;
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->disputeDeadline, $dto);
                    $this->successToast(__('ejalas::ejalas.dispute_deadline_updated_successfully'));
                    $this->showDisputeDeadlineForm = false;
                         $this->resetForm();
                    break;
                default:
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

       public function editDisputeDeadline(DisputeDeadline $disputeDeadline)
    {
        $this->disputeDeadline = $disputeDeadline;
        $this->action = Action::UPDATE;
       $this->showDisputeDeadlineForm = true;
          $this->dispatch('init-registration-date');
        
    }

    protected function resetForm()
{
    $this->reset('disputeDeadline');
          $this->disputeDeadline = new DisputeDeadline();
     $this->disputeDeadline->complaint_registration_id = $this->complaintRegistration->id;
    $this->action = Action::CREATE;
}

    
}
