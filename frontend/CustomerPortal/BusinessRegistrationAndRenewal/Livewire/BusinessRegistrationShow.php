<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use App\Traits\HelperDate;
use Livewire\Attributes\On;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessRegistrationShow extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?BusinessRegistration $businessRegistration = null;
    public bool $showBillUpload = false;
    public string $rejectionReason = '';
    public  $bill_no;
    public $amount;

    public function mount(BusinessRegistration $businessRegistration)
    {
       
        $this->businessRegistration = $businessRegistration;
        $this->rejectionReason = $businessRegistration->application_rejection_reason ?? '';
        $this->showBillUpload = $this->businessRegistration->status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
    }


    public function render()
    {
        return view("CustomerPortal.BusinessRegistrationAndRenewal::livewire.business-registration.show");
    }

    #[On('print-customer-business')]
    public function print()
    {
        $service = new BusinessRegistrationAdminService();
        return $service->getLetter($this->businessRegistration,'web');
        
    }
}
