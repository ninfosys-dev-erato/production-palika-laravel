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
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\BusinessRegistration\Service\BusinessDeRegistrationService;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessDeRegistrationShow extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?BusinessDeRegistration $businessDeRegistration = null;
    public bool $showBillUpload = false;
    public string $rejectionReason = '';
    public $bill_no;
    public $amount;
    public $bill;

    public array $dynamicFileUrls = [];


    public array $citizenshipFrontUrls = [];
    public array $citizenshipRearUrls = [];
    public array $applicants = [];

    public array $businessRequiredDocUrls = [];


    public function mount(BusinessDeRegistration $businessDeRegistration)
    {

        $this->businessDeRegistration = $businessDeRegistration;
        $this->businessDeRegistration->load('businessRegistration', 'businessRegistration.applicants', 'businessRegistration.requiredBusinessDocs');
        $this->rejectionReason = $businessDeRegistration->application_rejection_reason ?? '';
        $this->showBillUpload = $this->businessDeRegistration->status == ApplicationStatusEnum::SENT_FOR_PAYMENT->value;

        $this->generateTemporaryUrlsForCitizenship();
        $this->generateTemporaryUrlsForDocs();


        $this->generateTemporaryUrlsFromData();
    }



    public function generateTemporaryUrlsForCitizenship(): void
    {
        $this->applicants = $this->businessDeRegistration->businessRegistration->applicants->toArray();
        foreach ($this->applicants as $index => $applicant) {
            $this->citizenshipFrontUrls[$index] = $this->generateTemporaryUrl($applicant->citizenship_front ?? null);
            $this->citizenshipRearUrls[$index]  = $this->generateTemporaryUrl($applicant->citizenship_rear ?? null);
        }
    }

    public function generateTemporaryUrlsForDocs(): void
    {
        if (!$this->businessDeRegistration->businessRegistration->relationLoaded('requiredBusinessDocs')) {
            $this->businessDeRegistration->businessRegistration->load('requiredBusinessDocs');
        }

        foreach ($this->businessDeRegistration->businessRegistration->requiredBusinessDocs as $doc) {
            $this->businessRequiredDocUrls[$doc->id] = $this->generateTemporaryUrl($doc->document_filename);
        }
    }


    public function generateTemporaryUrlsFromData(): void
    {

        $data = $this->businessDeRegistration->data;


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

        $businessDeRegistration = $this->businessDeRegistration;
        if (!$businessDeRegistration) {
            abort(404, 'Business DeRegistration not found.');
        }
        $businessDeRegistration->amount = $this->amount;
        $businessDeRegistration->application_status = ApplicationStatusEnum::SENT_FOR_PAYMENT->value;
        $service = new BusinessDeRegistrationService();

        $service->sentForPayment($businessDeRegistration);
        $this->successFlash(__('businessregistration::businessregistration.successfully_sent_for_payment'));
        return redirect()->route('admin.business-deregistration.show', $businessDeRegistration->id);
    }

    public function approve()
    {
        $this->validate([
            'bill_no' => 'required|string|max:255',
        ]);
        $businessDeRegistration = $this->businessDeRegistration;
        if (!$businessDeRegistration) {
            abort(404, 'Business DeRegistration not found.');
        }
        $service = new BusinessDeRegistrationService();
        try {
            $registrationNumber = $service->generateBusinessDeRegistrationNumber();
            $registration_date_en = date('Y-m-d');
            $registration_date_ne = $this->adToBs($registration_date_en);

            $data = [
                'registration_number' => $registrationNumber,
                'registration_date' => $registration_date_ne,
                'registration_date_en' => $registration_date_en,
                'certificate_number' => $registrationNumber,
                'bill_no' => $this->bill_no,
            ];


            $service->accept($businessDeRegistration, $data);
            $this->successFlash(__('businessregistration::businessregistration.business_registration_approved_successfully'));
            return redirect()->route('admin.business-deregistration.show', $businessDeRegistration->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:255']);

        $businessDeRegistration = $this->businessDeRegistration;
        if (!$businessDeRegistration) {
            abort(404, 'Business DeRegistration not found.');
        }
        try {
            $businessDeRegistration->application_rejection_reason = $this->rejectionReason;

            $dto = BusinessRegistrationShowDto::fromModel($businessDeRegistration); // linter: BusinessDeRegistration used intentionally
            $service = new BusinessRegistrationAdminService();

            $service->reject($businessDeRegistration, $dto);
            session()->flash('message', 'Recommendation rejected successfully.');
            return redirect()->route('admin.business-deregistration.show', $businessDeRegistration->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function render()
    {

        return view("BusinessRegistration::livewire.business-deregistration.show");
    }
}
