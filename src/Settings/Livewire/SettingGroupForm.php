<?php

namespace Src\Settings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Settings\DTO\SettingGroupAdminDto;
use Src\Settings\Models\SettingGroup;
use Src\Settings\Service\SettingGroupAdminService;

class SettingGroupForm extends Component
{
    use SessionFlash;

    public ?SettingGroup $settingGroup;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'settingGroup.group_name' => ['required'],
    'settingGroup.group_name_ne' => ['required'],
    'settingGroup.is_public' => ['required'],
    'settingGroup.slug' => ['required'],
    'settingGroup.description' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'settingGroup.group_name.required' => __('settings::settings.group_name_is_required'),
            'settingGroup.group_name_ne.required' => __('settings::settings.group_name_ne_is_required'),
            'settingGroup.is_public.required' => __('settings::settings.is_public_is_required'),
            'settingGroup.slug.required' => __('settings::settings.slug_is_required'),
            'settingGroup.description.required' => __('settings::settings.description_is_required'),
        ];
    }

    public function render(){
        return view("Settings::livewire.setting-group-form");
    }

    public function mount(SettingGroup $settingGroup,Action $action)
    {
        $this->settingGroup = $settingGroup;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = SettingGroupAdminDto::fromLiveWireModel($this->settingGroup);
            $service = new SettingGroupAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('settings::settings.setting_group_created_successfully'));
                    return redirect()->route('admin.setting_groups.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->settingGroup,$dto);
                    $this->successFlash(__('settings::settings.setting_group_updated_successfully'));
                    return redirect()->route('admin.setting_groups.index');
                    break;
                default:
                    return redirect()->route('admin.setting_groups.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('settings::settings.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
