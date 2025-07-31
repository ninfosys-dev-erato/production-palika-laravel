<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;

class BusinessRenewalUploadBill extends Component
{
    use SessionFlash, WithFileUploads;

    public ?BusinessRenewal $businessRenewal = null;
    public bool $showBillUpload = false;
    public $payment_receipt; // Fixed property name

    public function mount(BusinessRenewal $businessRenewal)
    {
        $this->businessRenewal = $businessRenewal;
        $this->showBillUpload = $this->businessRenewal->application_status == ApplicationStatusEnum::SENT_FOR_PAYMENT;
    }

    public function uploadBill()
    {
        $this->validate([
            'payment_receipt' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);
        try {
            $path = ImageServiceFacade::compressAndStoreImage($this->payment_receipt, config('src.BusinessRegistration.businessRegistration.bill'), getStorageDisk('public'));
            $this->businessRenewal->payment_receipt = $path;
            $this->businessRenewal->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $service = new BusinessRenewalAdminService();
            $service->uploadBill($this->businessRenewal);
            $this->successFlash(__('businessregistration::businessregistration.bill_uploaded_successfully'));
            return redirect()->route('admin.business-registration.renewals.show', $this->businessRenewal->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while uploading bill.', $e->getMessage());
        }
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.renewal.upload-bill");
    }
}
