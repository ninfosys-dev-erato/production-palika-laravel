<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectActivityGroupAdminDto;
use Src\Yojana\Models\ProjectActivityGroup;
use Src\Yojana\Service\ProjectActivityGroupAdminService;
use Livewire\Attributes\On;
use Src\Yojana\Models\NormType;

class ProjectActivityGroupForm extends Component
{
    use SessionFlash;

    public ?ProjectActivityGroup $projectActivityGroup;
    public ?Action $action = Action::CREATE;

    public $projectActivityGroups;
    public $normTypes;

    public function rules(): array
    {
        return [
            'projectActivityGroup.title' => ['required'],
            'projectActivityGroup.code' => ['required'],
            'projectActivityGroup.group_id' => ['nullable'],
            'projectActivityGroup.norms_type' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'projectActivityGroup.title.required' => __('yojana::yojana.title_is_required'),
            'projectActivityGroup.code.required' => __('yojana::yojana.code_is_required'),
            'projectActivityGroup.group_id.nullable' => __('yojana::yojana.group_id_is_optional'),
            'projectActivityGroup.norms_type.nullable' => __('yojana::yojana.norms_type_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.project-activity-groups.form");
    }

    public function mount(ProjectActivityGroup $projectActivityGroup, Action $action)
    {
        $this->projectActivityGroup = $projectActivityGroup;
        $this->action = $action;
        $this->projectActivityGroups = ProjectActivityGroup::whereNull('deleted_at')->pluck('title', 'id');
        $this->normTypes = NormType::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectActivityGroupAdminDto::fromLiveWireModel($this->projectActivityGroup);
        $service = new ProjectActivityGroupAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.project_activity_group_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.project_activity_groups.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectActivityGroup, $dto);
                $this->successFlash(__('yojana::yojana.project_activity_group_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.project_activity_groups.index');
                break;
            default:
                return redirect()->route('admin.project_activity_groups.index');
                break;
        }
    }

    #[On('edit-projectActivityGroup')]
    public function projectActivityGroup(ProjectActivityGroup $projectActivityGroup)
    {
        $this->projectActivityGroup = $projectActivityGroup;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['projectActivityGroup', 'action']);
        $this->projectActivityGroup = new ProjectActivityGroup();
    }
}
