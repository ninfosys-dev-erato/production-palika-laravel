<?php

namespace Src\FuelSettings\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FuelSettings\Controllers\FuelSettingAdminController;
use Src\FuelSettings\DTO\FuelSettingAdminDto;
use Src\FuelSettings\Models\FuelSetting;
use Src\FuelSettings\Service\FuelSettingAdminService;
use Src\Wards\Models\Ward;

class FuelSettingForm extends Component
{
    use SessionFlash;

    public ?FuelSetting $fuelSetting;
    public ?Action $action;
    public $wards;
    public $users = [];
    public $selectedWard = null;

    public function rules(): array
    {
        return [
            'fuelSetting.acceptor_id' => ['required'],
            'fuelSetting.reviewer_id' => ['required'],
            'fuelSetting.expiry_days' => ['required'],
            'fuelSetting.ward_no' => ['required'],
        ];
    }

    public function render()
    {
        return view("FuelSettings::livewire.form");
    }

    public function wardUser()
    {
        if (!empty($this->fuelSetting['ward_no'])) {
            $this->users = User::whereHas('wards', function ($query) {
                $query->where('id', $this->fuelSetting['ward_no']);
            })->pluck('name', 'id');
        } else {
            $this->users = [];
        }
    }

    public function mount(FuelSetting $fuelSetting, Action $action)
    {
        $this->fuelSetting = $fuelSetting;
        $this->action = $action;
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_en', 'id');
        // dd($this->users->wards()->pluck('ward_name_en'));
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = FuelSettingAdminDto::fromLiveWireModel($this->fuelSetting);
            $service = new FuelSettingAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Fuel Setting Created Successfully");
                    return redirect()->route('admin.fuel_settings.index');
                case Action::UPDATE:
                    $service->update($this->fuelSetting, $dto);
                    $this->successFlash("Fuel Setting Updated Successfully");
                    return redirect()->route('admin.fuel_settings.index');
                default:
                    return redirect()->route('admin.fuel_settings.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
