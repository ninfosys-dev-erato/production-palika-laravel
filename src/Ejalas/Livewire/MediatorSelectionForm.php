<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\MediatorSelectionAdminDto;
use Src\Ejalas\Enum\MediatorSelectionType;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\Mediator;
use Src\Ejalas\Models\MediatorSelection;
use Src\Ejalas\Service\MediatorSelectionAdminService;

class MediatorSelectionForm extends Component
{
    use SessionFlash;
        protected $listeners = ['edit-mediatorSelectionForm' => 'editMediatorSelectionForm', 'selectedMediatorDeleted'=>'selectedMediatorDeleted'];


    public ?MediatorSelection $mediatorSelection;
    public ?Action $action =  Action::CREATE;
    public $complaintRegistration;
    public $mediators;
    public $mediatorSelectionTypes;

        public bool $canAddMediator = true;

  public $showMediatorForm = false;
  

    public function rules(): array
    {
        return [
            'mediatorSelection.complaint_registration_id' => ['required'],
            'mediatorSelection.mediator_id' => ['required'],
            'mediatorSelection.mediator_type' => ['required'],
            'mediatorSelection.selection_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.mediator-selection.form");
    }

    public function mount($complaintRegistration, MediatorSelection $mediatorSelection)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->mediatorSelection = $mediatorSelection ?? $this->getDefaultMediatorSelection();


        $this->mediators = Mediator::whereNull('deleted_at')->pluck('mediator_name', 'id');
        $this->mediatorSelectionTypes = MediatorSelectionType::getForWeb();

     $exists = MediatorSelection::whereNull('deleted_at')->where('complaint_registration_id', $complaintRegistration->id)->exists();
    $this->canAddMediator = !$exists;
    }

    
        public function toggleMediatorSelectionForm()
    {
        $this->showMediatorForm = !$this->showMediatorForm;

        if ($this->showMediatorForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = MediatorSelectionAdminDto::fromLiveWireModel($this->mediatorSelection);
            $service = new MediatorSelectionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.mediator_selection_created_successfully'));
                      $this->canAddMediator = false;
                    break;
                case Action::UPDATE:
                    $service->update($this->mediatorSelection, $dto);
                    $this->successToast(__('ejalas::ejalas.mediator_selection_updated_successfully'));
                    break;
                default:
                    break;
            }
                   $this->showMediatorForm = false;
        $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

     
    public function editMediatorSelectionForm(MediatorSelection $mediatorSelection)
    {
        $this->mediatorSelection = $mediatorSelection;
        $this->action = Action::UPDATE;
        $this->showMediatorForm = true;
        $this->dispatch('init-registration-date');
    }

 
    protected function resetForm()
    {
        $this->mediatorSelection = $this->getDefaultMediatorSelection();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultMediatorSelection(): MediatorSelection
    {


        $mediatorSelection = new MediatorSelection();
        $mediatorSelection->complaint_registration_id = $this->complaintRegistration->id;
    

        return $mediatorSelection;
    }
    public function selectedMediatorDeleted(){
            $this->canAddMediator = true;
    }
}
