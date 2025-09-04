<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Address\Models\Province;
use Src\Address\Models\District;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Models\Customer;
use Livewire\Attributes\On;
use Src\BusinessRegistration\Models\BusinessRegistration;

class BusinessOwnershipTransfer extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public array $personalDetails = [
        [
            'applicant_name' => '',
            'gender' => '',
            'father_name' => '',
            'grandfather_name' => '',
            'phone' => '',
            'email' => '',
            'citizenship_number' => '',
            'citizenship_issued_date' => '',
            'citizenship_issued_district' => '',
            'applicant_province' => '',
            'applicant_district' => '',
            'applicant_local_body' => '',
            'applicant_ward' => '',
            'applicant_tole' => '',
            'applicant_street' => '',
            'position' => '',
            'citizenship_front' => null,
            'citizenship_rear' => null,
            'citizenship_front_url' => null,
            'citizenship_rear_url' => null,
        ]
    ];

    public $provinces = [];
    public $applicantDistricts = [];
    public $applicantLocalBodies = [];
    public $applicantWards = [];
    public $genders;
    public $citizenshipDistricts;
    public $isCustomer = false;
    public BusinessRegistration $businessRegistration;
    public $activeTab = 'personal';

    public function rules(): array
    {
        return [
            'personalDetails.*.applicant_name' => ['required'],
            'personalDetails.*.gender' => ['nullable'],
            'personalDetails.*.father_name' => ['nullable'],
            'personalDetails.*.grandfather_name' => ['nullable'],
            'personalDetails.*.phone' => ['nullable'],
            'personalDetails.*.email' => ['nullable'],
            'personalDetails.*.citizenship_number' => ['nullable'],
            'personalDetails.*.citizenship_issued_date' => ['nullable'],
            'personalDetails.*.citizenship_issued_district' => ['nullable'],
            'personalDetails.*.applicant_province' => ['nullable'],
            'personalDetails.*.applicant_district' => ['nullable'],
            'personalDetails.*.applicant_local_body' => ['nullable'],
            'personalDetails.*.applicant_ward' => ['nullable'],
            'personalDetails.*.applicant_tole' => ['nullable'],
            'personalDetails.*.applicant_street' => ['nullable'],
            'personalDetails.*.position' => ['nullable'],
            'personalDetails.*.citizenship_front' => ['nullable'],
            'personalDetails.*.citizenship_rear' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'personalDetails.*.applicant_name.required' => __('businessregistration::businessregistration.the_applicant_name_is_required'),
        ];
    }

    public function render(): View
    {
        return view('BusinessRegistration::livewire.business-registration.ownership-transfer');
    }

    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;
        $this->provinces = Province::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->genders = GenderEnum::getValuesWithLabels();
        $this->citizenshipDistricts = District::whereNull('deleted_at')->pluck('title', 'id');
        $this->preSetDefaultAddress();
    }

    public function preSetDefaultAddress()
    {
        $defaultProvinceId = key(getSettingWithKey('palika-province'));
        $defaultDistrictId = key(getSettingWithKey('palika-district'));
        $defaultLocalBodyId = key(getSettingWithKey('palika-local-body'));

        $this->personalDetails[0]['applicant_province'] = $defaultProvinceId;
        $this->personalDetails[0]['applicant_district'] = $defaultDistrictId;
        $this->personalDetails[0]['applicant_local_body'] = $defaultLocalBodyId;

        $this->getApplicantDistricts(0);
        $this->getApplicantLocalBodies(0);
        $this->getApplicantWards(0);
    }

    public function addPersonalDetail()
    {
        $defaultProvinceId = key(getSettingWithKey('palika-province'));
        $defaultDistrictId = key(getSettingWithKey('palika-district'));
        $defaultLocalBodyId = key(getSettingWithKey('palika-local-body'));

        $this->personalDetails[] = [
            'applicant_name' => '',
            'gender' => '',
            'father_name' => '',
            'grandfather_name' => '',
            'phone' => '',
            'email' => '',
            'citizenship_number' => '',
            'citizenship_issued_date' => '',
            'citizenship_issued_district' => '',
            'applicant_province' => $defaultProvinceId,
            'applicant_district' => $defaultDistrictId,
            'applicant_local_body' => $defaultLocalBodyId,
            'applicant_ward' => '',
            'applicant_tole' => '',
            'applicant_street' => '',
            'position' => '',
            'citizenship_front' => null,
            'citizenship_rear' => null,
            'citizenship_front_url' => null,
            'citizenship_rear_url' => null,
        ];

        $index = count($this->personalDetails) - 1;

        $this->getApplicantDistricts($index);
        $this->getApplicantLocalBodies($index);
        $this->getApplicantWards($index);
    }

    public function removePersonalDetail($index)
    {
        unset($this->personalDetails[$index]);
        $this->personalDetails = array_values($this->personalDetails);
        $this->successToast(__('businessregistration::businessregistration.personal_detail_removed_successfully'));
    }

    public function getApplicantDistricts($index): void
    {
        $province = $this->personalDetails[$index]['applicant_province'] ?? null;
        $this->applicantDistricts[$index] = $province
            ? getDistricts($province)->pluck('title', 'id')->toArray()
            : [];
        $this->applicantLocalBodies[$index] = [];
        $this->applicantWards[$index] = [];
    }

    public function getApplicantLocalBodies($index): void
    {
        $district = $this->personalDetails[$index]['applicant_district'] ?? null;
        $this->applicantLocalBodies[$index] = $district
            ? getLocalBodies($district)->pluck('title', 'id')->toArray()
            : [];
        $this->applicantWards[$index] = [];
    }

    public function getApplicantWards($index): void
    {
        $localBodyId = $this->personalDetails[$index]['applicant_local_body'] ?? null;
        $this->applicantWards[$index] = $localBodyId
            ? getWards(optional(getLocalBodies(localBodyId: $localBodyId))->wards ?? [])
            : [];
    }

    public function updatedPersonalDetails($value, $name)
    {
        [$index, $field] = explode('.', $name);

        if (in_array($field, ['citizenship_front', 'citizenship_rear'])) {
            $file = $this->personalDetails[$index][$field] ?? null;
            $this->handleFileUpload($file, $field, (int)$index);
        }
    }

    private function handleFileUpload($file, $field, $index)
    {
        if (!$file) return;

        if (is_string($file)) {
            $filename = $file;
        } else {
            $filename = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                file: $file,
                disk: 'local',
                filename: ''
            );
        }

        $url = FileFacade::getTemporaryUrl(
            path: config('src.BusinessRegistration.businessRegistration.registration'),
            filename: $filename,
            disk: 'local'
        );

        $this->personalDetails[$index][$field] = $filename;
        $this->personalDetails[$index][$field . '_url'] = $url;
    }

    #[On('search-user')]
    public function restructureData($result, $personalDetailIndex = 0)
    {
        if ($result['type'] === 'Customer') {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            if ($customer) {
                if (!isset($this->personalDetails[$personalDetailIndex])) {
                    $this->addPersonalDetail();
                }

                $this->personalDetails[$personalDetailIndex]['applicant_name'] = $customer->name ?? '';
                $this->personalDetails[$personalDetailIndex]['phone'] = $customer->mobile_no ?? '';
                $this->personalDetails[$personalDetailIndex]['email'] = $customer->email ?? '';
                $this->personalDetails[$personalDetailIndex]['gender'] = $customer->gender->value ?? '';

                if ($customer->kyc) {
                    $this->personalDetails[$personalDetailIndex]['father_name'] = $customer->kyc->father_name ?? '';
                    $this->personalDetails[$personalDetailIndex]['grandfather_name'] = $customer->kyc->grandfather_name ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_number'] = $customer->kyc->document_number ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_issued_date'] = $customer->kyc->document_issued_date_nepali ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_issued_district'] = $customer->kyc->document_issued_at ?? '';

                    if ($customer->kyc->permanent_province_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_province'] = $customer->kyc->permanent_province_id;
                        $this->getApplicantDistricts($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_district_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_district'] = $customer->kyc->permanent_district_id;
                        $this->getApplicantLocalBodies($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_local_body_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_local_body'] = $customer->kyc->permanent_local_body_id;
                        $this->getApplicantWards($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_ward) {
                        $this->personalDetails[$personalDetailIndex]['applicant_ward'] = $customer->kyc->permanent_ward;
                    }
                    if ($customer->kyc->permanent_tole) {
                        $this->personalDetails[$personalDetailIndex]['applicant_tole'] = $customer->kyc->permanent_tole;
                    }
                }

                $this->successToast(__('businessregistration::businessregistration.customer_data_loaded_successfully'));
            }
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
}
