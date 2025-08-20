<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Services\FileService;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
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
    public $isCustomer = false;


    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->showBillUpload = $this->businessRegistration->application_status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
        if (Auth::guard('customer')->check()) {
            $this->isCustomer = true;
        }
    }

    public function uploadBill()
    {
        try {  

            $path = $this->businessRegistration->bill;
            if ($this->bill) {
                $path = FileFacade::saveFile(
                    config('src.BusinessRegistration.businessRegistration.bill'),
                    '',
                    $this->bill,
                    'local',
                );
            }
            $this->businessRegistration->bill = $path;
            $this->businessRegistration->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $dto = BusinessRegistrationShowDto::fromModel($this->businessRegistration);
            $service = new BusinessRegistrationAdminService();
            $service->uploadBill($this->businessRegistration, $dto, !$this->isCustomer);
            $this->successFlash(__('businessregistration::businessregistration.bill_uploaded_successfully'));
            return redirect()->route(
                $this->isCustomer
                    ? 'customer.business-registration.business-registration.show'
                    : 'admin.business-registration.business-registration.show',
                ['id' => $this->businessRegistration->id, 'type' => $this->businessRegistration->registration_type]
            );
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.business-registration.upload-bill");
    }
}
