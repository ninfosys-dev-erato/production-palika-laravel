<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessRegistrationUploadBill extends Component
{
    use SessionFlash, WithFileUploads;

    public ?BusinessRegistration $businessRegistration = null;
    public bool $showBillUpload = false;
    public $bill;


    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->showBillUpload = $this->businessRegistration->application_status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
    }

    public function uploadBill()
    {
        $this->validate([
            'bill' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);
        $path = ImageServiceFacade::compressAndStoreImage($this->bill, config('src.BusinessRegistration.businessRegistration.bill'), getStorageDisk('public'));
        $this->businessRegistration->bill = $path;
        $this->businessRegistration->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
        $dto = BusinessRegistrationShowDto::fromModel($this->businessRegistration);
        $service = new BusinessRegistrationAdminService();
        $service->uploadBill($this->businessRegistration, $dto, false);
        $this->successFlash(__("Bill uploaded successfully."));
        return redirect()->route('customer.business-registration.business-registration.show', $this->businessRegistration->id);
    }

    public function render()
    {
        return view("CustomerPortal.BusinessRegistrationAndRenewal::livewire.business-registration.upload-bill");
    }
}
