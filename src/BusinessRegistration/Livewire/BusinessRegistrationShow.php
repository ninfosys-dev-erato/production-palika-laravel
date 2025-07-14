<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
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
    public $bill;
    public array $businessRequiredDocUrls = [];

    public array $citizenshipFrontUrls = [];
    public array $citizenshipRearUrls = [];

    public array $dynamicFileUrls = [];


    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->rejectionReason = $businessRegistration->application_rejection_reason ?? '';
        $this->showBillUpload = $this->businessRegistration->status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;

        $this->generateTemporaryUrlsForDocs();
        $this->generateTemporaryUrlsForCitizenship();
        $this->generateTemporaryUrlsFromData();
    }

    public function generateTemporaryUrlsForDocs(): void
    {
        if (!$this->businessRegistration->relationLoaded('requiredBusinessDocs')) {
            $this->businessRegistration->load('requiredBusinessDocs');
        }

        foreach ($this->businessRegistration->requiredBusinessDocs as $doc) {
            $this->businessRequiredDocUrls[$doc->id] = $this->generateTemporaryUrl($doc->document_filename);
        }
    }

    public function generateTemporaryUrlsForCitizenship(): void
    {
        // For deregistration, get applicants from original business registration
        if ($this->businessRegistration->registration_type === BusinessRegistrationType::DEREGISTRATION && $this->businessRegistration->registration_id) {
            $originalBusiness = BusinessRegistration::withTrashed()->with(['applicants'])->where('id', $this->businessRegistration->registration_id)->first();
            $applicants = $originalBusiness?->applicants ?? $this->businessRegistration->applicants;
        } else {
            $applicants = $this->businessRegistration->applicants;
        }

        foreach ($applicants as $index => $applicant) {
            $this->citizenshipFrontUrls[$index] = $this->generateTemporaryUrl($applicant->citizenship_front ?? null);
            $this->citizenshipRearUrls[$index]  = $this->generateTemporaryUrl($applicant->citizenship_rear ?? null);
        }
    }

    public function generateTemporaryUrlsFromData(): void
    {
        // For deregistration, get data from original business registration
        if ($this->businessRegistration->registration_type === BusinessRegistrationType::DEREGISTRATION && $this->businessRegistration->registration_id) {
            $originalBusiness = BusinessRegistration::withTrashed()->where('id', $this->businessRegistration->registration_id)->first();
            $data = $originalBusiness?->data ?? $this->businessRegistration->data;
        } else {
            $data = $this->businessRegistration->data;
        }

        // Decode JSON if needed
        if (is_string($data)) {
            $data = json_decode($data, true);  // decode to associative array
        }

        if (empty($data) || !is_array($data)) {
            return; // no data to process or invalid format
        }

        foreach ($data as $key => $field) {
            if (($field['type'] ?? null) === 'file') {
                $values = is_array($field['value']) ? $field['value'] : [$field['value']];

                foreach ($values as $index => $filename) {
                    if ($filename) {
                        $this->dynamicFileUrls[$key][$index] = $this->generateTemporaryUrl($filename);
                    }
                }
            }
        }
    }

    private function generateTemporaryUrl(?string $filename): ?string
    {
        if (!$filename) return null;

        return FileFacade::getTemporaryUrl(
            path: config('src.BusinessRegistration.businessRegistration.registration'),
            filename: $filename,
            disk: 'local'
        );
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
        try {
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
        return view("BusinessRegistration::livewire.business-registration.show");
    }
}
