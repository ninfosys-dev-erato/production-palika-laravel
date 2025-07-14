<?php

namespace Src\Settings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Settings\Controllers\SettingAdminController;
use Src\Settings\DTO\MstSettingAdminDto;
use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;
use Src\Settings\Models\SettingGroup;
use Src\Settings\Service\MstSettingAdminService;

class MstSettingForm extends Component
{
    use SessionFlash;

    public ?MstSetting $setting;
    public ?SettingGroup $settingGroup;
    public ?Action $action;
    public array $needleOptions;

    public function rules(): array
    {
        return [
            'setting.group_id' => ['required'],
            'setting.label' => ['required'],
            'setting.label_ne' => ['required'],
            'setting.value' => ['nullable'],
            'setting.key_id' => ['nullable'],
            'setting.key_type' => ['nullable'],
            'setting.key_needle' => ['nullable'],
            'setting.key' => ['required'],
            'setting.description' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'setting.group_id.required' => __('settings::settings.group_id_is_required'),
            'setting.label.required' => __('settings::settings.label_is_required'),
            'setting.label_ne.required' => __('settings::settings.label_ne_is_required'),
            'setting.value.nullable' => __('settings::settings.value_is_optional'),
            'setting.key_id.nullable' => __('settings::settings.key_id_is_optional'),
            'setting.key_type.nullable' => __('settings::settings.key_type_is_optional'),
            'setting.key_needle.nullable' => __('settings::settings.key_needle_is_optional'),
            'setting.key.required' => __('settings::settings.key_is_required'),
            'setting.description.required' => __('settings::settings.description_is_required'),
        ];
    }

    public function render(){
        return view("Settings::livewire.form");
    }

    public function mount(MstSetting $setting,SettingGroup $settingGroup,Action $action)
    {
        $this->setting = $setting;
        $this->settingGroup = $settingGroup;
        $this->setting->group_id = $settingGroup->id;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = MstSettingAdminDto::fromLiveWireModel($this->setting);
            $service = new MstSettingAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->dispatch('close-modal');
                    $this->successToast(__('settings::settings.setting_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->setting,$dto);
                    $this->dispatch('close-modal');
                    $this->successToast(__('settings::settings.setting_updated_successfully'));
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('settings::settings.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

   public function loadNeedle($model){
        if($model){
            $this->needleOptions = (new $model)->getFillable();
        }else{
            $this->needleOptions = [];
        }
   }
}
