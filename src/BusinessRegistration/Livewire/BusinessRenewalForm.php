<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\BusinessRegistration\DTO\BusinessRenewalAdminDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;

class BusinessRenewalForm extends Component
{
    use SessionFlash;

    public $businessRegistrationId;
    public BusinessRegistration $businessRegistration;
    public BusinessRenewal $businessRenewal;
    public $businessData;
    public $search;

    protected $listeners = ['openBusinessRenewalForm' => 'loadBusinessRegistration'];

    public function rules(): array
    {
        return [
            'search' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'search.required' => __('businessregistration::businessregistration.the_search_field_is_required'),
        ];
    }


    public function searchBusiness()
    {
        $this->validate();
        $this->businessData = BusinessRegistration::with(
            'registrationType',
            'registrationType.registrationCategory',
            'requiredBusinessDocs',
            'applicants',
            'applicants.applicantProvince',
            'applicants.applicantDistrict',
            'applicants.applicantLocalBody',
            'applicants.citizenshipDistrict',
            'fiscalYear',
            'businessProvince',
            'businessDistrict',
            'businessLocalBody'
        )
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->where(function ($query) {
                $query->where('entity_name', $this->search)
                    ->orWhere('registration_number', $this->search);
            })
            ->where('application_status', ApplicationStatusEnum::ACCEPTED->value)
            ->where('business_status', BusinessStatusEnum::ACTIVE->value)
            ->first();


        if (is_null($this->businessData)) {
            $this->errorToast('No Data found with this name');
            return;
        }

        $fiscalYearId = getCurrentFiscalYear()->id;

        // Check for same registration number in the same fiscal year
        $exists = BusinessRenewal::where('business_registration_id', $this->businessData->id)
            ->where('fiscal_year_id', $fiscalYearId)
            ->exists();

        if ($exists) {
            $this->businessData = null;
            $this->errorFlash(__('businessregistration::businessregistration.renewal_already_exists_for_fiscal_year'));
            return;
        }
    }
    public function renewBusiness($businessRegistrationId)
    {
        $this->businessRegistrationId = $businessRegistrationId;

        $renewal = BusinessRenewal::create([
            'business_registration_id' => $this->businessData->id,
            'fiscal_year_id' => getCurrentFiscalYear()->id,
            'registration_no' => $this->businessData->certificate_number,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
            'application_status' => ApplicationStatusEnum::PENDING->value,

        ]);
        $this->successFlash(__('businessregistration::businessregistration.application_for_renewal_successful'));
        return redirect()->route('admin.business-registration.renewals.show', ['id' => $renewal->id]);
    }


    public function loadBusinessRegistration($businessRegistrationId)
    {

        $this->businessRegistrationId = $businessRegistrationId;

        $this->businessRegistration = BusinessRegistration::findOrFail($businessRegistrationId);
    }


    public function render()
    {
        return view("BusinessRegistration::livewire.renewal.form");
    }
}
