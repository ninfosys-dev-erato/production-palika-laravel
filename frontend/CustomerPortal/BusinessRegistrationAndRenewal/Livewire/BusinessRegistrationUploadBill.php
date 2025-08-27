<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use App\Facades\FileFacade;
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
        try {
            // Use FileFacade for all file types to avoid disk configuration issues
            $path = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.bill'),
                filename: '',
                file: $this->bill,
                disk: 'local'
            );
            
            $this->businessRegistration->bill = $path;
            $this->businessRegistration->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $dto = BusinessRegistrationShowDto::fromModel($this->businessRegistration);
            $service = new BusinessRegistrationAdminService();
            $service->uploadBill($this->businessRegistration, $dto, false);
            $this->successFlash(__("Bill uploaded successfully."));
            return redirect()->route('customer.business-registration.business-registration.show', $this->businessRegistration->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while uploading bill.', $e->getMessage());
        }
    }

    public function render()
    {
        return view("CustomerPortal.BusinessRegistrationAndRenewal::livewire.business-registration.upload-bill");
    }
}
