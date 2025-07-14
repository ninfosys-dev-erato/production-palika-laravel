<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\CooperativeTypeAdminController;
use Src\GrantManagement\DTO\CooperativeTypeAdminDto;
use Src\GrantManagement\Models\CooperativeType;
use Src\GrantManagement\Service\CooperativeTypeAdminService;
use Livewire\Attributes\On;

class CooperativeTypeForm extends Component
{
    use SessionFlash;

    public ?CooperativeType $cooperativeType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
    'cooperativeType.title' => ['required'],
    'cooperativeType.title_en' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'cooperativeType.title.required' => __('grantmanagement::grantmanagement.title_is_required'),
            'cooperativeType.title_en.required' => __('grantmanagement::grantmanagement.title_en_is_required'),
        ];
    }

    public function render(){
        return view("GrantManagement::livewire.cooperative-types-form");
    }

    public function mount(CooperativeType $cooperativeType,Action $action)
    {
        $this->cooperativeType = $cooperativeType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CooperativeTypeAdminDto::fromLiveWireModel($this->cooperativeType);
        $service = new CooperativeTypeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_type_created_successfully'));
                // return redirect()->route('admin.cooperative_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();
                
                break;
            case Action::UPDATE:
                $service->update($this->cooperativeType,$dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_type_updated_successfully'));
                // return redirect()->route('admin.cooperative_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();
                
                break;
            default:
                return redirect()->route('admin.cooperative_types.index');
                break;
        }
    }

    
    #[On('edit-cooperative-type')]
    public function editCooperativeType(CooperativeType $cooperativeType)
    {
        $this->cooperativeType = $cooperativeType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['cooperativeType', 'action']);
        $this->cooperativeType = new CooperativeType();
    }
    #[On('reset-form')]
    public function resetCooperativeType()
    {
        $this->resetForm();
    }

}
