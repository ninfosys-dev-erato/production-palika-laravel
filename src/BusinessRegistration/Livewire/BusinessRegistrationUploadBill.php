<?php

namespace Src\BusinessRegistration\Livewire;

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
        try{
            $path = ImageServiceFacade::compressAndStoreImage($this->bill, config('src.BusinessRegistration.businessRegistration.bill'), 'local');
            $this->businessRegistration->bill = $path;
            $this->businessRegistration->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $dto = BusinessRegistrationShowDto::fromModel($this->businessRegistration);
            $service = new BusinessRegistrationAdminService();
            $service->uploadBill($this->businessRegistration, $dto);
            $this->successFlash(__('businessregistration::businessregistration.bill_uploaded_successfully'));
            return redirect()->route('admin.business-registration.business-registration.show', $this->businessRegistration->id);
        }catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.business-registration.upload-bill");
    }
}
