<?php

namespace Src\BusinessRegistration\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessRegistrationReject extends Component
{
    use SessionFlash, WithFileUploads;

    public ?BusinessRegistration $businessRegistration = null;
    public bool $showBillUpload = false;
    public string $rejectionReason = '';
    public $bill;

    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->rejectionReason = $businessRegistration->application_rejection_reason ?? '';
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:255']);
        try {
            $this->businessRegistration->application_rejection_reason = $this->rejectionReason;
            $dto = BusinessRegistrationShowDto::fromModel($this->businessRegistration);
            $service = new BusinessRegistrationAdminService();
            $service->reject($this->businessRegistration, $dto);
            session()->flash('message', 'Recommendation rejected successfully.');
            return redirect()->route('admin.business-registration.business-registration.show', $this->businessRegistration->id);

        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }


    public function render()
    {
        return view("BusinessRegistration::livewire.business-registration.reject");
    }

    #[On('print-business')]
    public function print()
    {
        $service = new BusinessRegistrationAdminService();
        return $service->getLetter($this->businessRegistration,'web');
        
    }

}
