<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\LegalDocumentAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\LegalDocumentAdminService;

class LegalDocumentForm extends Component
{
    use SessionFlash;
       protected $listeners = ['edit-legalDocumentForm' => 'editLegalDocumentForm'];

    public ?LegalDocument $legalDocument;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public  $parties;
    public $showLegalDocumentForm = false;


    public function rules(): array
    {
        return [
            'legalDocument.complaint_registration_id' => ['required'],
            'legalDocument.party_name' => ['required'],
            'legalDocument.document_writer_name' => ['nullable'],
            'legalDocument.document_date' => ['nullable'],
            'legalDocument.document_details' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.legal-document.form");
    }

    public function mount($complaintRegistration, LegalDocument $legalDocument)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->legalDocument = $legalDocument;
        $this->parties = $complaintRegistration->parties->map(fn($party) => [
    'id' => $party->id,
    'name' => $party->name,
    'type' => $party->pivot->type,
]);

    }

       public function toggleLegalDocumentForm()
    {
        $this->showLegalDocumentForm = !$this->showLegalDocumentForm;

        if ($this->showLegalDocumentForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }



    public function save()
    {
      
        $this->validate();
        try {
            $dto = LegalDocumentAdminDto::fromLiveWireModel($this->legalDocument);
            $service = new LegalDocumentAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $legalDocument = $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.legal_document_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->legalDocument, $dto);
                    $this->successToast(__('ejalas::ejalas.legal_document_updated_successfully'));
                    break;
                default:
                    break;
            }
                $this->showLegalDocumentForm = false;
                      $this->resetForm(); // reset for next creation

        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


     public function editLegalDocumentForm(LegalDocument $legalDocument)
    {
        $this->legalDocument = $legalDocument;
        $this->action = Action::UPDATE;
        $this->showLegalDocumentForm = true;
        $this->dispatch('init-registration-date');
    }

 
    protected function resetForm()
    {
        $this->legalDocument = $this->getDefaultLegalDocument();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultLegalDocument(): legalDocument
    {


        $legalDocument = new legalDocument();
        $legalDocument->complaint_registration_id = $this->complaintRegistration->id;
    

        return $legalDocument;
    }

}
