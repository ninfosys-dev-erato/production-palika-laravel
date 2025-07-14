<?php

namespace Src\AdminSettings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\AdminSettings\Models\AdminSettingGroup;
use Src\AdminSettings\Service\AdminSettingGroupService;
use Src\AdminSettings\DTO\AdminSettingGroupDto;

class GroupForm extends Component
{
    use SessionFlash;

    public ?AdminSettingGroup $group;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'group.group_name' => ['required'],
            'group.description' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'group.group_name.required' => __('adminsettings::adminsettings.group_name_is_required'),
            'group.description.required' => __('adminsettings::adminsettings.description_is_required'),
        ];
    }

    public function render()
    {
        return view("AdminSettings::livewire.group.form");
    }

    public function mount(AdminSettingGroup $group, Action $action): void
    {
        $this->group = $group;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = AdminSettingGroupDto::fromLiveWireModel($this->group);
        $service = new AdminSettingGroupService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Group Created Successfully");
                break;
            case Action::UPDATE:
                $service->update($this->group, $dto);
                $this->successFlash("Group Updated Successfully");
                break;
        }
        return redirect()->route('admin.admin_setting.group.index');
    }
}
