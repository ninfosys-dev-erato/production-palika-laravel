<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Documents\Controllers\DocumentAdminController;
use Src\Ebps\DTO\DocumentAdminDto;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\Document;
use Src\Ebps\Service\DocumentAdminService;
use Livewire\Attributes\On;

class DocumentForm extends Component
{
    use SessionFlash;

    public ?Document $document;
    public ?Action $action = Action::CREATE;
    public $applicationTypes;


    public function rules(): array
    {
        return [
            'document.title' => ['required'],
            'document.application_type' => ['required'],
        ];
    }

    public function render(){
        return view("Ebps::livewire.document.document-form");
    }

    public function mount(Document $document,Action $action)
    {
        $this->document = $document;
        $this->action = $action;
        $this->applicationTypes = ApplicationTypeEnum::cases();
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = DocumentAdminDto::fromLiveWireModel($this->document);
            $service = new DocumentAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.document_created_successfully'));
                    // return redirect()->route('admin.ebps.documents.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->document,$dto);
                    $this->successFlash(__('ebps::ebps.document_updated_successfully'));
                    // return redirect()->route('admin.ebps.documents.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.documents.index');

            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('edit-document')]
    public function editDocument(Document $document)
    {
        $this->document = $document;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['document', 'action']);
        $this->document = new Document();
    }
    #[On('reset-form')]
    public function resetDocument()
    {
        $this->resetForm();
    }
}
