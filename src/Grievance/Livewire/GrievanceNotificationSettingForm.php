<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\Models\GrievanceNotificationSetting;

class GrievanceNotificationSettingForm extends Component
{
    use SessionFlash;
    public $module;
    public $settings = [
        'mail' => false,
        'sms' => false,
        'fcm' => false,
    ];

    public function mount($module)
    {
        $this->module = $module;
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $setting = GrievanceNotificationSetting::where('module', $this->module)->first();

        if ($setting) {
            $this->settings = [
                'mail' => $setting->mail,
                'sms' => $setting->sms,
                'fcm' => $setting->fcm,
            ];
        }
    }

    public function saveSettings()
    {
        GrievanceNotificationSetting::updateOrCreate(
            ['module' => $this->module],
            $this->settings
        );

        $this->successFlash(__('grievance::grievance.notification_settings_updated_successfully'));

    }

    public function render()
    {
        return view('Grievance::livewire.notification');
    }
}
