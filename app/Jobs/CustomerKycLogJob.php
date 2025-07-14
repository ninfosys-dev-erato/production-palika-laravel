<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\CustomerKyc\Model\CustomerKycVerificationLog;
use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Enums\LanguagePreferenceEnum;
use Src\Customers\Models\Customer;

class CustomerKycLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customerId;
    protected $kycOriginal;
    protected $kycChanges;
    protected $customerDetailOriginal;
    protected $customerDetailChanges;

    protected $ignoreFields = ['created_at', 'updated_at', 'kyc_verified_at', 'is_active'];
    protected $skipComparisonIfSame = ['document_image1', 'document_image2'];

    public function __construct(Customer $customer, array $originalKycAttributes, array $newKycAttributes, array $originalCustomerAttributes, array $newCustomerAttributes)
    {
        $this->customerId = $customer->id;
        $this->kycOriginal = $originalKycAttributes;
        $this->kycChanges = $newKycAttributes;
        $this->customerDetailOriginal = $originalCustomerAttributes;
        $this->customerDetailChanges = $newCustomerAttributes;
    }

    public function handle(): void
    {
        $changes = array_merge(
            $this->detectChanges($this->kycOriginal, $this->kycChanges),
            $this->detectChanges($this->customerDetailOriginal, $this->customerDetailChanges, true)
        );

        $remark = "Customer KYC details updated.\n" . $this->generateRemarks($changes);
        
        CustomerKycVerificationLog::create([
            'customer_id' => $this->customerId,
            'old_status' => $this->kycOriginal['status'],
            'new_status' => $this->kycChanges['status'],
            'old_customer_details' => json_encode($this->customerDetailOriginal),
            'new_customer_details' => json_encode($this->customerDetailChanges),
            'old_details' => json_encode($this->kycOriginal),
            'new_details' => json_encode($this->kycChanges),
            'remarks' => $remark,
        ]);
    }

    protected function detectChanges(array $original, array $changes, bool $isCustomerDetail = false): array
    {
        $detectedChanges = [];
        
        foreach ($changes as $key => $newValue) {
            if ($this->shouldSkipField($key, $original, $newValue)) {
                continue;
            }

            $originalValue = $this->getOriginalValue($original, $key, $isCustomerDetail);

            if ((string) $originalValue !== (string) $newValue) {
                $detectedChanges[] = [
                    'field' => $key,
                    'old' => $originalValue,
                    'new' => $newValue,
                ];
            }
        }

        return $detectedChanges;
    }

    protected function shouldSkipField($key, $original, $newValue): bool
    {
        if (in_array($key, $this->ignoreFields)) {
            return true;
        }

        return in_array($key, $this->skipComparisonIfSame) && ($original[$key] === $newValue);
    }

    protected function getOriginalValue(array $original, string $key, bool $isCustomerDetail): mixed
    {
        return match (true) {
            $key === 'status' && $original[$key] instanceof KycStatusEnum => $original[$key]->value,
            $key === 'document_type' && $original[$key] instanceof DocumentTypeEnum => $original[$key]->value,
            $isCustomerDetail && $key === 'gender' && $original[$key] instanceof GenderEnum => $original[$key]->value,
            $isCustomerDetail && $key === 'language_preference' && $original[$key] instanceof LanguagePreferenceEnum => $original[$key]->value,
            default => $original[$key]
        };
    }

    protected function generateRemarks(array $changes): string
    {
        return collect($changes)->map(function ($change) {
            return "→ " . ucfirst(str_replace('_', ' ', $change['field'])) . ": changed from '" . $change['old'] . "' to '" . $change['new'] . "'";
        })->implode("\n");
    }
}