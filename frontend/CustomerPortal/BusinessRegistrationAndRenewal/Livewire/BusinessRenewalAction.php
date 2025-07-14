<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;

class BusinessRenewalAction extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?BusinessRenewal $businessRenewal;
    public bool $showBillUpload = false;
    public $renew_amount;
    public  $penalty_amount;
    public  $payment_receipt;
    public  $date_to_be_maintained;
    public  $payment_receipt_date;

    public function mount(BusinessRenewal $businessRenewal)
    {
        $this->businessRenewal = $businessRenewal;
        $this->showBillUpload = $this->businessRenewal->application_status === ApplicationStatusEnum::SENT_FOR_PAYMENT;
    }

    public function render()
    {
        return view('CustomerPortal.BusinessRegistrationAndRenewal::livewire.renewal.action');
    }


    public function uploadBill()
    {
        $this->validate([
            'payment_receipt' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);
        try{
            $path = ImageServiceFacade::compressAndStoreImage($this->payment_receipt, config('src.BusinessRegistration.businessRegistration.bill'), 'local');
            $this->businessRenewal->payment_receipt = $path;
            $this->businessRenewal->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $service = new BusinessRenewalAdminService();
            $service->uploadBill(businessRenewal: $this->businessRenewal, admin: false);
            $this->successFlash(__("Bill uploaded successfully."));
            return redirect()->route('customer.business-registration.renewals.show', $this->businessRenewal->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

}
