<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Src\BusinessRegistration\DTO\NatureOfBusinessAdminDto;
use Src\BusinessRegistration\Models\NatureOfBusiness;
use Src\BusinessRegistration\Service\NatureOfBusinessAdminService;
use Livewire\Attributes\On;

class BusinessNatureForm extends Component
{
    use SessionFlash;

    public ?NatureOfBusiness $businessNature;
    public Action $action = Action::CREATE;

    public function mount(NatureOfBusiness $businessNature, Action $action)
    {
        $this->businessNature = $businessNature;
        $this->action = $action;
    }

    public function rules(): array
    {
        $rules = [
            'businessNature.title' => ['required'],
            'businessNature.title_ne' => ['required'],
        ];

        return $rules;
    }
    public function messages(): array
    {
        return [
            'businessNature.title.required' => __('businessregistration::businessregistration.title_is_required'),
            'businessNature.title_ne.required' => __('businessregistration::businessregistration.title_ne_is_required'),
        ];
    }

    public function render(): View
    {
        return view('BusinessRegistration::livewire.business-nature.form');
    }

    public function save()
    {
        $this->validate();
        try{

            $dto = NatureOfBusinessAdminDto::fromLiveWireModel($this->businessNature);
            $service = new NatureOfBusinessAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_nature_created_successfully'));
                    return redirect()->route('admin.business-registration.business-nature.index');

                case Action::UPDATE:
                    $service->update($this->businessNature, $dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_nature_updated_successfully'));
                    return redirect()->route('admin.business-registration.business-nature.index');
            }

        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-businessnature')]
    public function editBusinessNature(NatureOfBusiness $businessNature)
    {
        $this->businessNature = $businessNature;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset(['businessNature', 'action']);
        $this->businessNature = new NatureOfBusiness();
        $this->action = Action::CREATE;
    }
}
