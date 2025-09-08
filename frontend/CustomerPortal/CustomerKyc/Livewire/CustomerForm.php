<?php

namespace Frontend\CustomerPortal\CustomerKyc\Livewire;

use App\Enums\Action;
use App\Facades\ActivityLogFacade;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Rules\MobileNumberIdentifierRule;
use App\Services\ImageService;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Frontend\CustomerPortal\CustomerKyc\DTO\CustomerKycDto;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Address\Models\District;
use Src\CustomerKyc\Services\CustomerKycService;
use Src\Customers\DTO\CustomerAdminDto;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Models\Customer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Src\Customers\Models\CustomerKyc;

class CustomerForm extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?Customer $customer;
    public ?Action $action;
    public $provinces;
    public array $files = [];
    public $isSameAsPermanent = false;
    public array $temporaryDistricts = [];
    public array $permanentDistricts = [];
    public array $temporaryLocalBodies = [];
    public array $permanentLocalBodies = [];
    public array $temporaryWards = [];
    public array $permanentWards = [];
    public bool $isModalForm = false;
    public bool $isProvinceSelected = false;
    public  $uploadedImage1;
    public  $uploadedImage2;
    public array $districts = [];
    public bool $showDocumentBackInput = false;
    public ?CustomerKyc $kyc;
    public $existingImage1;
    public $existingImage2;

    public function rules(): array
    {
        $rules = [
            'customer.name' => ['required'],
            'customer.email' => ['nullable'],
            'customer.mobile_no' => ['required', 'numeric', 'digits:10', Rule::unique('tbl_customers', 'mobile_no')->ignore($this->customer->id)],
            'customer.gender' => ['required', Rule::in(GenderEnum::cases())],
            'kyc.nepali_date_of_birth' => ['required', 'string'],
            'kyc.grandfather_name' => ['required', 'string'],
            'kyc.father_name' => ['required', 'string'],
            'kyc.mother_name' => ['required', 'string'],
            'kyc.spouse_name' => ['nullable', 'string'],
            'kyc.permanent_province_id' => ['required', 'integer', 'exists:add_provinces,id,deleted_at,NULL'],
            'kyc.permanent_district_id' => ['required', 'integer', 'exists:add_districts,id,deleted_at,NULL'],
            'kyc.permanent_local_body_id' => ['required', 'integer', 'exists:add_local_bodies,id,deleted_at,NULL'],
            'kyc.permanent_ward' => ['required', 'integer'],
            'kyc.permanent_tole' => ['required', 'string'],
            'kyc.temporary_province_id' => ['nullable', 'integer', 'exists:add_provinces,id,deleted_at,NULL'],
            'kyc.temporary_district_id' => ['nullable', 'integer', 'exists:add_districts,id,deleted_at,NULL'],
            'kyc.temporary_local_body_id' => ['nullable', 'integer', 'exists:add_local_bodies,id,deleted_at,NULL'],
            'kyc.temporary_ward' => ['nullable', 'integer'],
            'kyc.temporary_tole' => ['nullable', 'string'],
            'kyc.document_type' => ['required', 'string'],
            'kyc.document_issued_date_nepali' => ['required', 'string'],
            'kyc.document_issued_at' => ['required'],
            'kyc.document_number' => ['required', 'string'],
            'uploadedImage1' => ['required', 'max:10240'],
            'kyc.expiry_date_english' => ['nullable', 'date'],
        ];
        $rules['uploadedImage1'] = $this->getImageValidationRules($this->uploadedImage1);

        if ($this->showDocumentBackInput) {
            $rules['uploadedImage2'] = $this->getImageValidationRules($this->uploadedImage2);
        } else {
            $rules['uploadedImage2'] = ['nullable', 'max:10240'];
        }

        return $rules;
    }

    /**
     * Get validation rules for uploaded images.
     *
     * @param mixed $image
     * @return array
     */
    private function getImageValidationRules($image): array
    {
        return is_string($image)
            ? ['required', 'max:10240']
            : ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
    }

    public function messages(): array
    {
        return [
            'customer.name.required' => __('The customer name is required.'),
            'customer.email.nullable' => __('The customer email is optional.'),
            'customer.mobile_no.required' => __('The customer mobile number is required.'),
            'customer.mobile_no.numeric' => __('The customer mobile number must be numeric.'),
            'customer.mobile_no.digits' => __('The customer mobile number must be exactly 10 digits.'),
            'customer.mobile_no.unique' => __('The customer mobile number has already been taken.'),
            'customer.gender.required' => __('The customer gender is required.'),
            'customer.gender.in' => __('The selected customer gender is invalid.'),
            'kyc.grandfather_name.string' => __('The grandfather name must be a string.'),
            'kyc.father_name.string' => __('The father name must be a string.'),
            'kyc.mother_name.string' => __('The mother name must be a string.'),
            'kyc.spouse_name.string' => __('The spouse name must be a string.'),
            'kyc.permanent_province_id.required' => __('The permanent province is required.'),
            'kyc.permanent_province_id.integer' => __('The permanent province must be an integer.'),
            'kyc.permanent_province_id.exists' => __('The selected permanent province is invalid.'),
            'kyc.permanent_district_id.required' => __('The permanent district is required.'),
            'kyc.permanent_district_id.integer' => __('The permanent district must be an integer.'),
            'kyc.permanent_district_id.exists' => __('The selected permanent district is invalid.'),
            'kyc.permanent_local_body_id.required' => __('The permanent local body is required.'),
            'kyc.permanent_local_body_id.integer' => __('The permanent local body must be an integer.'),
            'kyc.permanent_local_body_id.exists' => __('The selected permanent local body is invalid.'),
            'kyc.permanent_ward_id.integer' => __('The permanent ward must be an integer.'),
            'kyc.permanent_ward_id.required' => __('The permanent ward is required.'),
            'kyc.permanent_tole.string' => __('The permanent tole must be a string.'),
            'kyc.temporary_province_id.integer' => __('The temporary province must be an integer.'),
            'kyc.temporary_province_id.exists' => __('The selected temporary province is invalid.'),
            'kyc.temporary_district_id.integer' => __('The temporary district must be an integer.'),
            'kyc.temporary_district_id.exists' => __('The selected temporary district is invalid.'),
            'kyc.temporary_local_body_id.integer' => __('The temporary local body must be an integer.'),
            'kyc.temporary_local_body_id.exists' => __('The selected temporary local body is invalid.'),
            'kyc.temporary_ward_id.integer' => __('The temporary ward must be an integer.'),
            'kyc.temporary_tole.string' => __('The temporary tole must be a string.'),
            'kyc.document_type.required' => __('The document type is required.'),
            'kyc.document_type.string' => __('The document type must be a string.'),
            'kyc.document_issued_at.required' => __('The document issued at field is required.'),
            'kyc.document_issued_at.string' => __('The document issued at must be a string.'),
            'kyc.document_number.required' => __('The document number is required.'),
            'kyc.document_number.string' => __('The document number must be a string.'),
            'uploadedImage1.file' => __('The document image 1 must be a file.'),
            'uploadedImage1.mimes' => __('The document image 1 must be a file of type: jpg, jpeg, png, pdf.'),
            'uploadedImage1.max' => __('The document image 1 must not exceed 10 MB.'),
            'uploadedImage2.file' => __('The document image 2 must be a file.'),
            'uploadedImage2.mimes' => __('The document image 2 must be a file of type: jpg, jpeg, png, pdf.'),
            'uploadedImage2.max' => __('The document image 2 must not exceed 10 MB.'),
            'kyc.expiry_date_english.date' => __('The English expiry date must be a valid date.'),
        ];
    }

    public function render()
    {
        $genderOptions = collect(\Src\Customers\Enums\GenderEnum::cases())
            ->mapWithKeys(fn($gender) => [$gender->value => $gender->label()])
            ->toArray();

        $documentOptions = collect(\Src\Customers\Enums\DocumentTypeEnum::cases())
            ->mapWithKeys(fn($documentType) => [$documentType->value => $documentType->label()])
            ->toArray();

        return view("CustomerPortal.CustomerKyc::livewire.form", ['genderOptions' => $genderOptions, 'documentOptions' => $documentOptions, 'provinces' => $this->provinces]);
    }

    public function permanentLoadDistricts()
    {
        $this->permanentDistricts = getDistricts($this->kyc['permanent_province_id'])->pluck('title', 'id')->toArray();
        $this->permanentLocalBodies = [];
        $this->permanentWards = [];
    }
    public function temporaryLoadDistricts()
    {
        $this->temporaryDistricts = getDistricts($this->kyc['temporary_province_id'])->pluck('title', 'id')->toArray();

        $this->temporaryLocalBodies = [];
        $this->temporaryWards = [];
    }

    public function permanentLoadLocalBodies(): void
    {
        $this->permanentLocalBodies = getLocalBodies(district_ids: $this->kyc['permanent_district_id'])->pluck('title', 'id')->toArray();

        $this->permanentWards = [];
    }
    public function temporaryLoadLocalBodies(): void
    {
        $this->temporaryLocalBodies = getLocalBodies(district_ids: $this->kyc['temporary_district_id'])->pluck('title', 'id')->toArray();

        $this->temporaryWards = [];
    }

    public function temporaryLoadWards(): void
    {
        $this->temporaryWards = getWards(getLocalBodies(localBodyId: $this->kyc['temporary_local_body_id'])->wards);
    }
    public function permanentLoadWards(): void
    {
        $this->permanentWards = getWards(getLocalBodies(localBodyId: $this->kyc['permanent_local_body_id'])->wards);
    }

    public function mount(Customer $customer, Action $action, bool $isModalForm = false)
    {
        $this->customer = $customer;
        if ($this->customer->kyc) {
            $this->kyc = $this->customer->kyc;
        } else {
            $this->kyc = new CustomerKyc();
        }
        if ($this->customer->kyc && $this->customer) {
            $this->permanentLoadDistricts();
            $this->permanentLoadLocalBodies();
            $this->permanentLoadWards();
            $this->temporaryLoadDistricts();
            $this->temporaryLoadLocalBodies();
            $this->temporaryLoadWards();
            $this->uploadedImage1 = $this->kyc->document_image1;
            $this->uploadedImage2 = $this->kyc->document_image2;
            $this->updateDocumentNumber();
        }
        $this->action = $action;
        $this->isModalForm = $isModalForm;
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->districts = District::all(['id', 'title'])
            ->mapWithKeys(fn($provinces) => [$provinces->id => $provinces->title])
            ->toArray();
    }
    public function checkIsSameAsPermanent()
    {
        $this->isSameAsPermanent = !$this->isSameAsPermanent;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->initializeDates($this->kyc['nepali_date_of_birth'], $this->kyc['document_issued_date_nepali'], $this->kyc['expiry_date_english']);
            if ($this->isSameAsPermanent) {

                $this->kyc->temporary_province_id = $this->kyc->permanent_province_id;
                $this->kyc->temporary_district_id = $this->kyc->permanent_district_id;
                $this->kyc->temporary_local_body_id = $this->kyc->permanent_local_body_id;
                $this->kyc->temporary_ward = $this->kyc->permanent_ward;
                $this->kyc->temporary_tole = $this->kyc->permanent_tole;
            }
            if (
                $this->kyc['document_type']->value === "national_id" ||
                $this->kyc['document_type']->value === "citizenship"
            ) {
                $this->kyc->document_image1 = $this->handleFileIfValid($this->uploadedImage1);
                $this->kyc->document_image2 = $this->uploadedImage2 ? $this->handleFileIfValid($this->uploadedImage2) : null;
            } else {

                $this->kyc->document_image1 = $this->handleFileIfValid($this->uploadedImage1);
                $this->kyc->document_image2 = null;
            }

            $dto = CustomerAdminDto::fromLiveWireModel($this->customer, $this->kyc);

            $service = new CustomerKycService();

            $webCustomer = true;
            ActivityLogFacade::logForCustomer();
            $service->storeCustomerKyc($dto,  $this->customer, $webCustomer);
            $this->successFlash(__("Kyc Updated Successfully"));
            return redirect()->route('customer.kyc.index');
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    private function handleFileIfValid($file)
    {
        if (
            $file instanceof \Illuminate\Http\File ||
            $file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
            $file instanceof \Illuminate\Http\UploadedFile
        ) {
            return $this->handleFileUpload($file);
        }
        return $file;
    }

    public function handleFileUpload($file)
    {
        return FileFacade::saveFile(config('src.CustomerKyc.customerKyc.path'), "", $file, 'local');
    }

    private function initializeDates(string | null $nepaliDob, string | null $nepaliDocIssuedDate, string | null $engExpiryDate): void
    {
        $this->kyc['english_date_of_birth'] = $nepaliDob != null ? $this->bsToAd($nepaliDob) : null;
        $this->kyc['document_issued_date_english'] = $nepaliDocIssuedDate != null ? $this->bsToAd($nepaliDocIssuedDate) : null;
        $this->kyc['expiry_date_nepali'] = $engExpiryDate != null ? $this->adToBs($engExpiryDate) : null;
    }

    public function updateDocumentNumber()
    {
        if (
            $this->kyc['document_type']->value === "national_id" ||
            $this->kyc['document_type']->value === "citizenship"
        ) {
            $this->showDocumentBackInput = true;
        } else {
            $this->showDocumentBackInput = false;
        }
    }
}
