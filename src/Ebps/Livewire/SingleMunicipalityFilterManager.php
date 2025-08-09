<?php

namespace Src\Ebps\Livewire;

use Livewire\Component;
use Src\Ebps\Models\SingleFilterSetting;
use App\Traits\SessionFlash;

class SingleMunicipalityFilterManager extends Component
{
    use SessionFlash;

    public $currentSetting;
    public $isEnabled;
    public $description;

    public function mount()
    {
        $this->loadSetting();
    }

    public function render()
    {
        return view('Ebps::livewire.single-municipality-filter-manager');
    }

    public function loadSetting()
    {
        $this->currentSetting = SingleFilterSetting::getSetting();
        $this->isEnabled = $this->currentSetting->enable_role_filtering;
        $this->description = $this->currentSetting->description;
    }

    public function toggleFilter()
    {
        try {
            $newValue = SingleFilterSetting::toggleRoleFiltering();
            
            $this->loadSetting();
            
            if ($newValue) {
                $this->successFlash('✅ Role filtering ENABLED - Users only see applications they can work on');
            } else {
                $this->successFlash('🔓 Role filtering DISABLED - All users see all applications');
            }
        } catch (\Exception $e) {
            $this->errorFlash('Error updating filter setting: ' . $e->getMessage());
        }
    }

    public function enableFiltering()
    {
        try {
            SingleFilterSetting::enableRoleFiltering();
            $this->loadSetting();
            $this->successFlash('✅ Role filtering ENABLED - Users only see applications they can work on');
        } catch (\Exception $e) {
            $this->errorFlash('Error enabling filter: ' . $e->getMessage());
        }
    }

    public function disableFiltering()
    {
        try {
            SingleFilterSetting::disableRoleFiltering();
            $this->loadSetting();
            $this->successFlash('🔓 Role filtering DISABLED - All users see all applications');
        } catch (\Exception $e) {
            $this->errorFlash('Error disabling filter: ' . $e->getMessage());
        }
    }
}
 