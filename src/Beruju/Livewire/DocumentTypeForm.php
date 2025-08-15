<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Beruju\DTO\DocumentTypeAdminDto;
use Src\Beruju\Models\DocumentType;
use Src\Beruju\Service\DocumentTypeAdminService;
use Livewire\Attributes\On;

class DocumentTypeForm extends Component
{
    use SessionFlash;

    public ?DocumentType $documentType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'documentType.name_eng' => ['nullable'],
            'documentType.name_nep' => ['required'],
            'documentType.remarks' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'documentType.name_nep.required' => __('beruju::beruju.name_nep_required'),
            'documentType.remarks.nullable' => __('beruju::beruju.no_remarks'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.document-type-form");
    }

    public function mount($documentType = null, Action $action = Action::CREATE)
    {
        if ($documentType instanceof DocumentType) {
            $this->documentType = $documentType;
        } elseif (is_numeric($documentType)) {
            $this->documentType = DocumentType::find($documentType) ?? new DocumentType();
        } else {
            $this->documentType = new DocumentType();
        }
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = DocumentTypeAdminDto::fromLiveWireModel($this->documentType);
        $service = new DocumentTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('beruju::beruju.document_type_created_successfully'));
                $this->dispatch('close-modal');
                break;
            case Action::UPDATE:
                $service->update($this->documentType, $dto);
                $this->successFlash(__('beruju::beruju.document_type_updated_successfully'));
                $this->dispatch('close-modal');
                break;
            default:
                return redirect()->route('admin.beruju.document-types.index');
                break;
        }
        // Stay on the same page; the index view listens to close-modal and hides the modal
    }

    #[On('edit-document-type')]
    public function editDocumentType(DocumentType $documentType)
    {
        $this->documentType = $documentType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetDocumentType()
    {
        $this->reset(['documentType', 'action']);
        $this->documentType = new DocumentType();
    }
}
