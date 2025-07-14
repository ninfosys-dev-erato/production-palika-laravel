<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\FarmerGroupAdminController;
use Src\GrantManagement\DTO\FarmerGroupAdminDto;
use Src\GrantManagement\Models\FarmerGroup;
use Src\GrantManagement\Service\FarmerGroupAdminService;

class FarmerGroupForm extends Component
{
    use SessionFlash;

    public ?FarmerGroup $farmerGroup;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'farmerGroup.farmer_id' => ['required'],
            'farmerGroup.group_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'farmerGroup.farmer_id.required' => __('grantmanagement::grantmanagement.farmer_id_is_required'),
            'farmerGroup.group_id.required' => __('grantmanagement::grantmanagement.group_id_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.farmer-groups-form");
    }

    public function mount(FarmerGroup $farmerGroup, Action $action)
    {
        $this->farmerGroup = $farmerGroup;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = FarmerGroupAdminDto::fromLiveWireModel($this->farmerGroup);
        $service = new FarmerGroupAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.farmer_group_created_successfully'));
                return redirect()->route('admin.farmer_groups.index');
                break;
            case Action::UPDATE:
                $service->update($this->farmerGroup, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.farmer_group_updated_successfully'));
                return redirect()->route('admin.farmer_groups.index');
                break;
            default:
                return redirect()->route('admin.farmer_groups.index');
                break;
        }
    }
}
