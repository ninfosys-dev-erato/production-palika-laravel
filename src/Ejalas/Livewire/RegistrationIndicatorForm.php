<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\RegistrationIndicatorAdminDto;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Models\RegistrationIndicator;
use Src\Ejalas\Service\RegistrationIndicatorAdminService;
use Livewire\Attributes\On;

class RegistrationIndicatorForm extends Component
{
    use SessionFlash;

    public ?RegistrationIndicator $registrationIndicator;
    public ?Action $action = Action::CREATE;
    public $partyTypes;

    public function rules(): array
    {
        return [
            'registrationIndicator.dispute_title' => ['required'],
            'registrationIndicator.indicator_type' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.registration-indicator.form");
    }

    public function mount(RegistrationIndicator $registrationIndicator, Action $action)
    {
        $this->registrationIndicator = $registrationIndicator;
        $this->action = $action;

        $this->partyTypes = PartyType::getValuesWithLabels();
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = RegistrationIndicatorAdminDto::fromLiveWireModel($this->registrationIndicator);
            $service = new RegistrationIndicatorAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.registration_indicator_created_successfully'));
                    // return redirect()->route('admin.ejalas.registration_indicators.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->registrationIndicator, $dto);
                    $this->successFlash(__('ejalas::ejalas.registration_indicator_updated_successfully'));
                    // return redirect()->route('admin.ejalas.registration_indicators.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.registration_indicators.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


    #[On('edit-registration-indicator')]
    public function editRegistrationIndicator(RegistrationIndicator $registrationIndicator)
    {
        $this->registrationIndicator = $registrationIndicator;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['registrationIndicator', 'action']);
        $this->registrationIndicator = new RegistrationIndicator();
    }
    #[On('reset-form')]
    public function resetRegistrationIndicator()
    {
        $this->resetForm();
    }
}
