<?php

namespace Src\Settings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Settings\Models\MstSetting;
use Src\Settings\Service\MstSettingAdminService;

class SettingItemForm extends Component
{
    use SessionFlash;

    public ?MstSetting $setting;
    public ?Action $action;
    public array $options;
    public function rules(): array
    {
        return [
            'setting.value' => ['required'],
            'setting.key_id' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'setting.value.required' => __('settings::settings.value_is_required'),
            'setting.key_id.nullable' => __('settings::settings.key_id_is_optional'),
        ];
    }

    public function render()
    {
        return view("Settings::livewire.setting.form-item",);
    }

    public function mount(string $setting_key): void
    {
        $this->setting = MstSetting::where('key', $setting_key)->first();

        if ($this->setting && !empty($this->setting->key_type) && class_exists($this->setting->key_type)) {
            $this->options = (new $this->setting->key_type)->get()->pluck($this->setting->key_needle, 'id')->toArray();
        } else {
            $this->options = [];
        }
    }

    public function updateKey(int $selectedKey)
    {
        if (array_key_exists($selectedKey, $this->options)) {
            $this->setting->key_id = $selectedKey;
            $this->setting->value = $this->options[$selectedKey];
        }
    }

    public function save()
    {
        $this->validate();
        try{
            $service = new MstSettingAdminService();
            $service->setValue(
                setting: $this->setting,
                value: $this->setting->value,
                key_id: $this->setting->key_id
            );
            $this->successToast(__('settings::settings.value_updated_successfully'));
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('settings::settings.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
