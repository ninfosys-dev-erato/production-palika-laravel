<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
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
    public ?bool $showBillUpload = false;
    public ?int $renew_amount = 0;
    public ?int $penalty_amount = 0;
    public $payment_receipt;
    public ?string $date_to_be_maintained;
    public ?string $payment_receipt_date;
    public ?int $bill_no;

    // File URL arrays for temporary access
    public array $businessRequiredDocUrls = [];
    public array $citizenshipFrontUrls = [];
    public array $citizenshipRearUrls = [];
    public array $dynamicFileUrls = [];

    public function mount(BusinessRenewal $businessRenewal)
    {
        $this->businessRenewal = $businessRenewal;
        $this->showBillUpload = $this->businessRenewal->application_status == ApplicationStatusEnum::SENT_FOR_PAYMENT;

        // Generate temporary URLs for files
        $this->generateTemporaryUrlsForDocs();
        $this->generateTemporaryUrlsForCitizenship();
        $this->generateTemporaryUrlsFromData();
    }

    public function generateTemporaryUrlsForDocs(): void
    {
        if (!$this->businessRenewal->registration->relationLoaded('requiredBusinessDocs')) {
            $this->businessRenewal->registration->load('requiredBusinessDocs');
        }

        foreach ($this->businessRenewal->registration->requiredBusinessDocs as $doc) {
            $this->businessRequiredDocUrls[$doc->id] = $this->generateTemporaryUrl($doc->document_filename);
        }
    }

    public function generateTemporaryUrlsForCitizenship(): void
    {
        foreach ($this->businessRenewal->registration->applicants as $index => $applicant) {
            $this->citizenshipFrontUrls[$index] = $this->generateTemporaryUrl($applicant->citizenship_front ?? null);
            $this->citizenshipRearUrls[$index] = $this->generateTemporaryUrl($applicant->citizenship_rear ?? null);
        }
    }

    public function generateTemporaryUrlsFromData(): void
    {
        // Decode JSON if needed
        $data = $this->businessRenewal->registration->data;

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
            disk: getStorageDisk('private')
        );
    }

    public function render()
    {
        return view('BusinessRegistration::livewire.renewal.action');
    }

    public function sendForPayment()
    {
        $this->validate([
            'penalty_amount' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'renew_amount' => ['sometimes', 'numeric', 'min:0'],
        ]);
        try {
            $this->businessRenewal->renew_amount = $this->renew_amount;
            $this->businessRenewal->penalty_amount = $this->penalty_amount;
            $this->businessRenewal->application_status = ApplicationStatusEnum::SENT_FOR_PAYMENT;
            $service = new BusinessRenewalAdminService();
            $service->sentForPayment($this->businessRenewal);
            $this->successFlash(__('businessregistration::businessregistration.successfully_sent_for_payment'));
            return redirect()->route('admin.business-registration.renewals.show', $this->businessRenewal->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function uploadBill()
    {
        $this->validate([
            'payment_receipt' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);
        try {
            $path = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.bill'),
                filename: '',
                file: $this->payment_receipt,
                disk: 'local'
            );

            $this->businessRenewal->payment_receipt = $path;
            $this->businessRenewal->application_status = ApplicationStatusEnum::BILL_UPLOADED->value;
            $service = new BusinessRenewalAdminService();
            $service->uploadBill($this->businessRenewal);
            $this->successFlash(__('businessregistration::businessregistration.bill_uploaded_successfully'));
            return redirect()->route('admin.business-registration.renewals.show', $this->businessRenewal->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    public function approveRenewal()
    {
        $this->validate([
            'bill_no' => ['required'],
            'date_to_be_maintained' => ['required'],
            'payment_receipt_date' => ['required'],
        ]);

        try {
            $renew_date_en = date('Y-m-d');
            $renew_date_ne = $this->adToBs($renew_date_en);

            $this->businessRenewal->bill_no = $this->bill_no;
            $this->businessRenewal->renew_date = $renew_date_ne;
            $this->businessRenewal->renew_date_en = $renew_date_en;
            $this->businessRenewal->date_to_be_maintained_en = $this->bsToAd($this->date_to_be_maintained);
            $this->businessRenewal->date_to_be_maintained = $this->convertNepaliToEnglish($this->date_to_be_maintained);
            $this->businessRenewal->payment_receipt_date_en = $this->bsToAd($this->payment_receipt_date);
            $this->businessRenewal->payment_receipt_date = $this->convertNepaliToEnglish($this->payment_receipt_date);
            $this->businessRenewal->application_status = ApplicationStatusEnum::ACCEPTED->value;

            $service = new BusinessRenewalAdminService();
            $service->approveRenewal($this->businessRenewal);
            $this->successFlash(__('businessregistration::businessregistration.renewal_successfully'));
            return redirect()->route('admin.business-registration.renewals.show', $this->businessRenewal->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }
}
