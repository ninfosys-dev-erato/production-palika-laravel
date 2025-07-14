<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\BusinessRegistration\DTO\BusinessRenewalAdminDto;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;

class BusinessRenewalForm extends Component
{
    use SessionFlash;

    public $businessRegistrationId;
    public BusinessRegistration $businessRegistration;
    public BusinessRenewal $businessRenewal;

    protected $listeners = ['openBusinessRenewalForm' => 'loadBusinessRegistration'];

    public function loadBusinessRegistration($businessRegistrationId)
    {
        $this->businessRegistrationId = $businessRegistrationId;

        $this->businessRegistration = BusinessRegistration::findOrFail($businessRegistrationId);
        $this->dispatch('showModal');
    }


    public function render()
    {
        return view("BusinessRegistration::livewire.renewal.form");
    }
}
