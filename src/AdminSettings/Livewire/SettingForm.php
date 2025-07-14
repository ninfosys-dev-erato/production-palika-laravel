<?php

namespace Src\AdminSettings\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\AdminSettings\DTO\AdminSettingDto;
use Src\AdminSettings\Models\AdminSetting;
use Src\AdminSettings\Models\AdminSettingGroup;
use Src\AdminSettings\Service\AdminSettingService;
use Src\AdminSettings\Enums\ModuleEnum;
use App\Enums\Action;

class SettingForm extends Component
{
    public ?AdminSetting $setting;
    public ?Action $action;
    public $groups = [];
    public $labels = [];


    public function rules(): array
    {
        return [
            'setting.group_id' => ['required', 'integer'],
            'setting.label' => ['required', 'string'],
            'setting.select_from' => ['nullable',Rule::in(ModuleEnum::cases())],
            'setting.value' => ['nullable', 'string'],
            'setting.created_by' => ['nullable', 'integer'],
            'setting.updated_by' => ['nullable', 'integer'],
            'setting.deleted_by' => ['nullable', 'integer'],
        ];
    }
    public function messages(): array
    {
        return [
            'setting.group_id.required' => __('adminsettings::adminsettings.group_id_is_required'),
            'setting.group_id.integer' => __('adminsettings::adminsettings.group_id_must_be_an_integer'),
            'setting.label.required' => __('adminsettings::adminsettings.label_is_required'),
            'setting.label.string' => __('adminsettings::adminsettings.label_must_be_a_string'),
            'setting.select_from.nullable' => __('adminsettings::adminsettings.select_from_is_optional'),
            'setting.select_from.Rule::in(ModuleEnum::cases())' => __('adminsettings::adminsettings.select_from_has_invalid_validation_rule'),
            'setting.value.nullable' => __('adminsettings::adminsettings.value_is_optional'),
            'setting.value.string' => __('adminsettings::adminsettings.value_must_be_a_string'),
            'setting.created_by.nullable' => __('adminsettings::adminsettings.created_by_is_optional'),
            'setting.created_by.integer' => __('adminsettings::adminsettings.created_by_must_be_an_integer'),
            'setting.updated_by.nullable' => __('adminsettings::adminsettings.updated_by_is_optional'),
            'setting.updated_by.integer' => __('adminsettings::adminsettings.updated_by_must_be_an_integer'),
            'setting.deleted_by.nullable' => __('adminsettings::adminsettings.deleted_by_is_optional'),
            'setting.deleted_by.integer' => __('adminsettings::adminsettings.deleted_by_must_be_an_integer'),
        ];
    }

    public function mount(AdminSetting $setting, Action $action): void
    {
        $this->setting = $setting;
        $this->action = $action;
        $this->groups = AdminSettingGroup::pluck('group_name', 'id')->toArray();
    }

    public function save()
    {
        $this->validate();
        $dto = AdminSettingDto::fromLiveWireModel($this->setting);
        $service = new AdminSettingService();
        
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                session()->flash('success', "Setting Created Successfully");
                break;
            case Action::UPDATE:
                $service->update($this->setting, $dto);
                session()->flash('success', "Setting Updated Successfully");
                break;
        }
        return redirect()->route('admin.admin_setting.setting.index');
    }

    public function render()
    {
        return view("AdminSettings::livewire.setting.form");
    }
}
