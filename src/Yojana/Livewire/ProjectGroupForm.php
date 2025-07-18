<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectGroupAdminDto;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectGroup;
use Src\Yojana\Service\ProjectGroupAdminService;
use Livewire\Attributes\On;

class ProjectGroupForm extends Component
{
    use SessionFlash;

    public ?ProjectGroup $projectGroup;
    public ?Action $action = Action::CREATE;
    public $planAreas;
    public $projectGroups;

    public function rules(): array
    {
        return [
            'projectGroup.title' => ['required'],
            'projectGroup.group_id' => ['nullable'],
            'projectGroup.area_id' => ['required'],
            'projectGroup.code' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'projectGroup.title.required' => __('yojana::yojana.title_is_required'),
            'projectGroup.group_id.nullable' => __('yojana::yojana.group_id_is_optional'),
            'projectGroup.area_id.required' => __('yojana::yojana.area_id_is_required'),
            'projectGroup.code.required' => __('yojana::yojana.code_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.project-groups.form");
    }

    public function mount(ProjectGroup $projectGroup, Action $action)
    {
        $this->projectGroup = $projectGroup;
        $this->action = $action;
        $this->planAreas = PlanArea::whereNull('deleted_at')->pluck('area_name', 'id');
        $this->projectGroups = ProjectGroup::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectGroupAdminDto::fromLiveWireModel($this->projectGroup);
        $service = new ProjectGroupAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.project_group_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.project_groups.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectGroup, $dto);
                $this->successFlash(__('yojana::yojana.project_group_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.project_groups.index');
                break;
            default:
                return redirect()->route('admin.project_groups.index');
                break;
        }
    }


    #[On('edit-projectGroup')]
    public function editProjectGroup(ProjectGroup $projectGroup)
    {
        $this->projectGroup = $projectGroup;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['projectGroup', 'action']);
        $this->projectGroup = new ProjectGroup();
    }
}
