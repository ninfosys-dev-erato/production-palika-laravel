<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectDocumentAdminDto;
use Src\Yojana\Models\ProjectDocument;
use Src\Yojana\Service\ProjectDocumentAdminService;

class ProjectDocumentForm extends Component
{
    use SessionFlash;

    public ?ProjectDocument $projectDocument;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectDocument.project_id' => ['required'],
    'projectDocument.document_name' => ['required'],
    'projectDocument.data' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectDocument.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectDocument.document_name.required' => __('yojana::yojana.document_name_is_required'),
            'projectDocument.data.required' => __('yojana::yojana.data_is_required'),
        ];
    }

    public function render(){
        return view("ProjectDocuments::projects.form");
    }

    public function mount(ProjectDocument $projectDocument,Action $action)
    {
        $this->projectDocument = $projectDocument;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectDocumentAdminDto::fromLiveWireModel($this->projectDocument);
        $service = new ProjectDocumentAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Document Created Successfully");
                return redirect()->route('admin.project_documents.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectDocument,$dto);
                $this->successFlash("Project Document Updated Successfully");
                return redirect()->route('admin.project_documents.index');
                break;
            default:
                return redirect()->route('admin.project_documents.index');
                break;
        }
    }
}
