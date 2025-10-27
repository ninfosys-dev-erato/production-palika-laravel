<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\WrittenResponseRegistrationAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\WrittenResponseRegistration;
use Src\Ejalas\Service\WrittenResponseRegistrationAdminService;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Models\RegistrationIndicator;

class WrittenResponseRegistrationForm extends Component
{
    use SessionFlash;

    public ?WrittenResponseRegistration $writtenResponseRegistration;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $registrationIndicators;
    public array $selectedIndicators = []; //stores data in the json format
    public bool $canAddResponse = true;

  public $showResponseForm = false;

    protected $listeners = ['edit-responseForm' => 'editResponseForm', 'responseDeleted'=>'responseDeleted'];

    public function rules(): array
    {
        return [
            'writtenResponseRegistration.response_registration_no' => ['required'],
            'writtenResponseRegistration.complaint_registration_id' => ['required'],
            'writtenResponseRegistration.registration_date' => ['required'],
            'writtenResponseRegistration.fee_amount' => ['required'],
            'writtenResponseRegistration.fee_receipt_no' => ['required'],
            'writtenResponseRegistration.fee_paid_date' => ['required'],
            'writtenResponseRegistration.description' => ['required'],
            'writtenResponseRegistration.claim_request' => ['required'],
            'writtenResponseRegistration.submitted_within_deadline' => ['nullable'],
            'writtenResponseRegistration.fee_receipt_attached' => ['nullable'],
            'writtenResponseRegistration.status' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.written-response-registration.form");
    }

    public function mount($complaintRegistration, WrittenResponseRegistration $writtenResponseRegistration)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->writtenResponseRegistration = $writtenResponseRegistration ?? $this->getDefaultResponseRegistration();
 

        $this->registrationIndicators = RegistrationIndicator::whereNull('deleted_at')->where('indicator_type', PartyType::Defender)->pluck('dispute_title', 'id');

     $exists = WrittenResponseRegistration::whereNull('deleted_at')->where('complaint_registration_id', $complaintRegistration->id)->exists();
    $this->canAddResponse = !$exists;

    }

        public function toggleResponseRegistrationForm()
    {
        $this->showResponseForm = !$this->showResponseForm;

        if ($this->showResponseForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }

 
    public function updatedSelectedIndicators($value)
    {
        if (in_array('पूरा नभएको', $this->selectedIndicators)) {
            $this->writtenResponseRegistration['status'] = "Rejected";
        } else {
            $this->writtenResponseRegistration['status'] = "Approved";
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $this->writtenResponseRegistration->registration_indicator = json_encode($this->selectedIndicators, JSON_UNESCAPED_UNICODE);
            $dto = WrittenResponseRegistrationAdminDto::fromLiveWireModel($this->writtenResponseRegistration);
            $service = new WrittenResponseRegistrationAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.written_response_registration_created_successfully'));
                           $this->canAddResponse = false;
                    break;
                case Action::UPDATE:
                    $service->update($this->writtenResponseRegistration, $dto);
                    $this->successToast(__('ejalas::ejalas.written_response_registration_updated_successfully'));
                    break;
                default:
                    break;
            }
        $this->showResponseForm = false;
        $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    
    public function editResponseForm(WrittenResponseRegistration $writtenResponseRegistration)
    {
        $this->writtenResponseRegistration = $writtenResponseRegistration;
        $this->action = Action::UPDATE;
        $this->showResponseForm = true;
        $this->dispatch('init-registration-date');
    }

 
    protected function resetForm()
    {
        $this->writtenResponseRegistration = $this->getDefaultCourtNotice();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultCourtNotice(): WrittenResponseRegistration
    {


        $writtenResponseRegistration = new WrittenResponseRegistration();
        $writtenResponseRegistration->complaint_registration_id = $this->complaintRegistration->id;
        $writtenResponseRegistration->response_registration_no = WrittenResponseRegistration::max('id') + 1;
    

        return $writtenResponseRegistration;
    }
    public function responseDeleted(){
            $this->canAddResponse = true;
    }

}

