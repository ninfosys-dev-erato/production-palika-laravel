<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectAgreementTermAdminDto;
use Src\Yojana\Models\ProjectAgreementTerm;
use Src\Yojana\Service\ProjectAgreementTermAdminService;

class ProjectAgreementTermForm extends Component
{
    use SessionFlash;

    public ?ProjectAgreementTerm $projectAgreementTerm;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectAgreementTerm.project_id' => ['required'],
    'projectAgreementTerm.data' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectAgreementTerm.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectAgreementTerm.data.required' => __('yojana::yojana.data_is_required'),
        ];
    }

    public function render(){
        return view("project-agreement-terms::projects.form");
    }

    public function mount(ProjectAgreementTerm $projectAgreementTerm,Action $action)
    {
        $this->projectAgreementTerm = $projectAgreementTerm;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectAgreementTermAdminDto::fromLiveWireModel($this->projectAgreementTerm);
        $service = new ProjectAgreementTermAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Agreement Term Created Successfully");
                return redirect()->route('admin.project_agreement_terms.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectAgreementTerm,$dto);
                $this->successFlash("Project Agreement Term Updated Successfully");
                return redirect()->route('admin.project_agreement_terms.index');
                break;
            default:
                return redirect()->route('admin.project_agreement_terms.index');
                break;
        }
    }
}
