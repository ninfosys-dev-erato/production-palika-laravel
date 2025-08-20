<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationDto;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationUploadDto;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\BusinessRegistration\Service\BusinessDeRegistrationService;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessDeRegistrationUploadBill extends Component
{
    use SessionFlash, WithFileUploads;

    public ?BusinessDeRegistration $businessDeRegistration = null;
    public bool $showBillUpload = false;
    public $bill;


    public function mount(BusinessDeRegistration $businessDeRegistration)
    {
        $this->businessDeRegistration = $businessDeRegistration;
        $this->showBillUpload = $this->businessDeRegistration->application_status == ApplicationStatusEnum::SENT_FOR_PAYMENT;
    }

    public function uploadBill()
    {
        $this->validate([
            'bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
        try {
            $path = $this->businessDeRegistration->bill; // default to existing value
            if ($this->bill) {
                
                $path = FileFacade::saveFile(
                    path: config('src.BusinessRegistration.businessRegistration.bill'),
                    filename: '',
                    file: $this->bill,
                    disk: 'local'
                );
            }
            $this->businessDeRegistration->bill = $path;
            $this->businessDeRegistration->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $dto = BusinessDeRegistrationUploadDto::fromModel($this->businessDeRegistration);

            $service = new BusinessDeRegistrationService();

            $service->uploadBill($this->businessDeRegistration, $dto);
            $this->successFlash(__('businessregistration::businessregistration.bill_uploaded_successfully'));
            return redirect()->route('admin.business-deregistration.show', $this->businessDeRegistration->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while uploading bill.', $e->getMessage());
        }
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.business-deregistration.upload-bill");
    }
}
