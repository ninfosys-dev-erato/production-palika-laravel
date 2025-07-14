<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectDeadlineExtensionAdminDto;
use Src\Yojana\Models\ProjectDeadlineExtension;
use Src\Yojana\Service\ProjectDeadlineExtensionAdminService;

class ProjectDeadlineExtensionForm extends Component
{
    use SessionFlash;

    public ?ProjectDeadlineExtension $projectDeadlineExtension;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectDeadlineExtension.project_id' => ['required'],
    'projectDeadlineExtension.extended_date' => ['required'],
    'projectDeadlineExtension.en_extended_date' => ['required'],
    'projectDeadlineExtension.submitted_date' => ['required'],
    'projectDeadlineExtension.en_submitted_date' => ['required'],
    'projectDeadlineExtension.remarks' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectDeadlineExtension.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectDeadlineExtension.extended_date.required' => __('yojana::yojana.extended_date_is_required'),
            'projectDeadlineExtension.en_extended_date.required' => __('yojana::yojana.en_extended_date_is_required'),
            'projectDeadlineExtension.submitted_date.required' => __('yojana::yojana.submitted_date_is_required'),
            'projectDeadlineExtension.en_submitted_date.required' => __('yojana::yojana.en_submitted_date_is_required'),
            'projectDeadlineExtension.remarks.required' => __('yojana::yojana.remarks_is_required'),
        ];
    }

    public function render(){
        return view("ProjectDeadlineExtensions::livewire.form");
    }

    public function mount(ProjectDeadlineExtension $projectDeadlineExtension,Action $action)
    {
        $this->projectDeadlineExtension = $projectDeadlineExtension;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectDeadlineExtensionAdminDto::fromLiveWireModel($this->projectDeadlineExtension);
        $service = new ProjectDeadlineExtensionAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Deadline Extension Created Successfully");
                return redirect()->route('admin.project_deadline_extensions.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectDeadlineExtension,$dto);
                $this->successFlash("Project Deadline Extension Updated Successfully");
                return redirect()->route('admin.project_deadline_extensions.index');
                break;
            default:
                return redirect()->route('admin.project_deadline_extensions.index');
                break;
        }
    }
}
