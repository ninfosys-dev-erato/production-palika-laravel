<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\CooperativeFarmerAdminController;
use Src\GrantManagement\DTO\CooperativeFarmerAdminDto;
use Src\GrantManagement\Models\CooperativeFarmer;
use Src\GrantManagement\Service\CooperativeFarmerAdminService;

class CooperativeFarmerForm extends Component
{
    use SessionFlash;

    public ?CooperativeFarmer $cooperativeFarmer;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'cooperativeFarmer.cooperative_id' => ['required'],
    'cooperativeFarmer.farmer_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'cooperativeFarmer.cooperative_id.required' => __('grantmanagement::grantmanagement.cooperative_id_is_required'),
            'cooperativeFarmer.farmer_id.required' => __('grantmanagement::grantmanagement.farmer_id_is_required'),
        ];
    }

    public function render(){
        return view("GrantManagement::livewire.cooperative-farmers-form");
    }

    public function mount(CooperativeFarmer $cooperativeFarmer,Action $action)
    {
        $this->cooperativeFarmer = $cooperativeFarmer;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CooperativeFarmerAdminDto::fromLiveWireModel($this->cooperativeFarmer);
        $service = new CooperativeFarmerAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_farmer_created_successfully'));
                return redirect()->route('admin.cooperative_farmers.index');
                break;
            case Action::UPDATE:
                $service->update($this->cooperativeFarmer,$dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_farmer_updated_successfully'));
                return redirect()->route('admin.cooperative_farmers.index');
                break;
            default:
                return redirect()->route('admin.cooperative_farmers.index');
                break;
        }
    }
}
