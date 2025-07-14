<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\EnterpriseFarmerAdminController;
use Src\GrantManagement\DTO\EnterpriseFarmerAdminDto;
use Src\GrantManagement\Models\EnterpriseFarmer;
use Src\GrantManagement\Service\EnterpriseFarmerAdminService;

class EnterpriseFarmerForm extends Component
{
    use SessionFlash;

    public ?EnterpriseFarmer $enterpriseFarmer;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'enterpriseFarmer.enterprise_id' => ['required'],
    'enterpriseFarmer.farmer_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'enterpriseFarmer.enterprise_id.required' => __('grantmanagement::grantmanagement.enterprise_id_is_required'),
            'enterpriseFarmer.farmer_id.required' => __('grantmanagement::grantmanagement.farmer_id_is_required'),
        ];
    }

    public function render(){
        return view("GrantManagement::livewire.enterprise-farmers-form");
    }

    public function mount(EnterpriseFarmer $enterpriseFarmer,Action $action)
    {
        $this->enterpriseFarmer = $enterpriseFarmer;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = EnterpriseFarmerAdminDto::fromLiveWireModel($this->enterpriseFarmer);
        $service = new EnterpriseFarmerAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_farmer_created_successfully'));
                return redirect()->route('admin.enterprise_farmers.index');
                break;
            case Action::UPDATE:
                $service->update($this->enterpriseFarmer,$dto);
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_farmer_updated_successfully'));
                return redirect()->route('admin.enterprise_farmers.index');
                break;
            default:
                return redirect()->route('admin.enterprise_farmers.index');
                break;
        }
    }
}
