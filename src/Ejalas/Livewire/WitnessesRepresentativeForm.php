<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\WitnessesRepresentativeAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\WitnessesRepresentative;
use Src\Ejalas\Service\WitnessesRepresentativeAdminService;

class WitnessesRepresentativeForm extends Component
{
    use SessionFlash;

    public ?WitnessesRepresentative $witnessesRepresentative;
  public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    
  public $showWitnessRepresentativeForm = false;
      protected $listeners = ['edit-witnessRepresentativeForm' => 'editWitnessRepresentativeForm'];

    public function rules(): array
    {
        return [
            'witnessesRepresentative.complaint_registration_id' => ['required'],
            'witnessesRepresentative.name' => ['required'],
            'witnessesRepresentative.address' => ['required'],
            'witnessesRepresentative.is_first_party' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.witness-representative.form");
    }

    public function mount($complaintRegistration, WitnessesRepresentative $witnessesRepresentative)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->witnessesRepresentative = $witnessesRepresentative ?? $this->getDefaultWitnessRepresentative();
    }
    public function toggleWitnessRegistrationForm()
    {
        $this->showWitnessRepresentativeForm = !$this->showWitnessRepresentativeForm;

        if ($this->showWitnessRepresentativeForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = WitnessesRepresentativeAdminDto::fromLiveWireModel($this->witnessesRepresentative);
            $service = new WitnessesRepresentativeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.witnesses_representative_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->witnessesRepresentative, $dto);
                    $this->successToast(__('ejalas::ejalas.witnesses_representative_updated_successfully'));
                    break;
                default:
                    break;
            }
                   $this->showWitnessRepresentativeForm = false;
        $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

        public function editWitnessRepresentativeForm(WitnessesRepresentative $witnessesRepresentative)
    {
        $this->witnessesRepresentative = $witnessesRepresentative;
        $this->action = Action::UPDATE;
        $this->showWitnessRepresentativeForm = true;
        $this->dispatch('init-registration-date');
    }

    protected function resetForm()
    {
        $this->witnessesRepresentative = $this->getDefaultWitnessRepresentative();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultWitnessRepresentative(): WitnessesRepresentative
    {


        $witnessesRepresentative = new WitnessesRepresentative();
        $witnessesRepresentative->complaint_registration_id = $this->complaintRegistration->id;
    

        return $witnessesRepresentative;
    }

}
