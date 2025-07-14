<?php

namespace Src\BusinessRegistration\Livewire;

use App\Traits\HelperDate;
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
    public $bill_no;
    public $amount;


    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->rejectionReason = $businessRegistration->application_rejection_reason ?? '';
        $this->showBillUpload = $this->businessRegistration->status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
    }

    public function sendForPayment()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        $this->businessRegistration->amount = $this->amount;
        $this->businessRegistration->application_status = ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
        $service = new BusinessRegistrationAdminService();
        $service->sentForPayment($this->businessRegistration);
        $this->successFlash(__('businessregistration::businessregistration.successfully_sent_for_payment'));
        return redirect()->route('admin.business-registration.business-registration.show', $this->businessRegistration->id);
    }

    public function approve()
    {
        $this->validate([
            'bill_no' => 'required|string|max:255',
        ]);

        $service = new BusinessRegistrationAdminService();
        try{
            $registrationNumber = $service->generateBusinessRegistrationNumber();
            $registration_date_en = date('Y-m-d');
            $registration_date_ne = $this->adToBs($registration_date_en);

            $data = [
                'registration_number' => $registrationNumber,
                'registration_date' => $registration_date_ne,
                'registration_date_en' => $registration_date_en,
                'certificate_number' => $registrationNumber,
                'bill_no' => $this->bill_no,
            ];

            $service->accept($this->businessRegistration, $data);
            $this->successFlash(__('businessregistration::businessregistration.business_registration_approved_successfully'));
            return redirect()->route('admin.business-registration.business-registration.show', $this->businessRegistration->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }


    public function render()
    {
        return view("BusinessRegistration::livewire.business-registration.show");
    }
}
