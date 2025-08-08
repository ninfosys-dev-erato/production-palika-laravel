<?php

namespace Src\Customers\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Rules\MobileNumberIdentifierRule;
use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Address\Models\District;
use Src\Customers\DTO\CustomerAdminDto;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Models\Customer;
use Src\Customers\Service\CustomerAdminService;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Src\Address\Models\Province;

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
    public bool $isForGrievance = false;
    public bool $isProvinceSelected = false;
    public $uploadedImage1;
    public $uploadedImage2;
    public array $districts = [];
    public bool $showDocumentBackInput = false;

    public function rules(): array
    {
        if ($this->isForGrievance) {
            return [

                'customer.name' => ['required'],
                'customer.email' => ['nullable', 'email', 'unique:tbl_customers,email'],
                'customer.gender' => ['required', Rule::in(GenderEnum::cases())],
                'customer.mobile_no' => ['required', 'numeric', 'digits:10', Rule::unique('tbl_customers', 'mobile_no')->ignore($this->customer->id), new MobileNumberIdentifierRule()],
            ];
        }

        $rules = [
            'customer.name' => ['required'],
            'customer.email' => ['nullable'],
            'customer.mobile_no' => ['required', 'numeric', 'digits:10', Rule::unique('tbl_customers', 'mobile_no')->ignore($this->customer->id), new MobileNumberIdentifierRule()],
            'customer.gender' => ['required', Rule::in(GenderEnum::cases())],
            'customer.nepali_date_of_birth' => ['required', 'string'],
            'customer.grandfather_name' => ['required', 'string'],
            'customer.father_name' => ['required', 'string'],
            'customer.mother_name' => ['required', 'string'],
            'customer.spouse_name' => ['nullable', 'string'],
            'customer.permanent_province_id' => ['required', 'integer', 'exists:add_provinces,id,deleted_at,NULL'],
            'customer.permanent_district_id' => ['required', 'integer', 'exists:add_districts,id,deleted_at,NULL'],
            'customer.permanent_local_body_id' => ['required', 'integer', 'exists:add_local_bodies,id,deleted_at,NULL'],
            'customer.permanent_ward' => ['required', 'integer'],
            'customer.permanent_tole' => ['required', 'string'],
            'customer.temporary_province_id' => ['nullable', 'integer', 'exists:add_provinces,id,deleted_at,NULL'],
            'customer.temporary_district_id' => ['nullable', 'integer', 'exists:add_districts,id,deleted_at,NULL'],
            'customer.temporary_local_body_id' => ['nullable', 'integer', 'exists:add_local_bodies,id,deleted_at,NULL'],
            'customer.temporary_ward' => ['nullable', 'integer'],
            'customer.temporary_tole' => ['nullable', 'string'],
            'customer.document_type' => ['required', 'string'],
            'customer.document_issued_date_nepali' => ['required', 'string'],
            'customer.document_issued_at' => ['required', 'string'],
            'customer.document_number' => ['required', 'string'],
            'uploadedImage1' => ['required', 'max:10240'],
            'customer.expiry_date_english' => ['nullable', 'date'],
        ];

        if ($this->showDocumentBackInput) {
            $rules['uploadedImage2'] = ['required',  'mimes:jpg,jpeg,png,pdf', 'max:10240'];
        } else {
            $rules['uploadedImage2'] = ['nullable',  'mimes:jpg,jpeg,png,pdf', 'max:10240'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer.name.required' => __('The customer name is required.'),
            'customer.email.nullable' => __('The customer email is optional.'),
            'customer.email.unique' => __("This email has already been taken."),
            'customer.mobile_no.required' => __('The customer mobile number is required.'),
            'customer.mobile_no.numeric' => __('The customer mobile number must be numeric.'),
            'customer.mobile_no.digits' => __('The customer mobile number must be exactly 10 digits.'),
            'customer.mobile_no.unique' => __('The customer mobile number has already been taken.'),
            'customer.gender.required' => __('The customer gender is required.'),
            'customer.gender.in' => __('The selected customer gender is invalid.'),
            'customer.nepali_date_of_birth' => __('The nepali date of birth field is required.'),
            'customer.grandfather_name.required' => __('The grandfather\'s name is required.'),
            'customer.father_name.required' => __('The father\'s name is required.'),
            'customer.mother_name.required' => __('The mother\'s name is required.'),
            'customer.spouse_name.string' => __('The spouse name is required.'),
            'customer.permanent_province_id.required' => __('The permanent province is required.'),
            'customer.permanent_province_id.integer' => __('The permanent province must be an integer.'),
            'customer.permanent_province_id.exists' => __('The selected permanent province is invalid.'),
            'customer.permanent_district_id.required' => __('The permanent district is required.'),
            'customer.permanent_district_id.integer' => __('The permanent district must be an integer.'),
            'customer.permanent_district_id.exists' => __('The selected permanent district is invalid.'),
            'customer.permanent_local_body_id.required' => __('The permanent local body is required.'),
            'customer.permanent_local_body_id.integer' => __('The permanent local body must be an integer.'),
            'customer.permanent_local_body_id.exists' => __('The selected permanent local body is invalid.'),
            'customer.permanent_ward.integer' => __('The permanent ward must be an integer.'),
            'customer.permanent_ward.required' => __('The permanent ward is required.'),
            'customer.permanent_tole.required' => __('The permanent tole is required.'),
            'customer.temporary_province_id.integer' => __('The temporary province must be an integer.'),
            'customer.temporary_province_id.exists' => __('The selected temporary province is invalid.'),
            'customer.temporary_district_id.integer' => __('The temporary district must be an integer.'),
            'customer.temporary_district_id.exists' => __('The selected temporary district is invalid.'),
            'customer.temporary_local_body_id.integer' => __('The temporary local body must be an integer.'),
            'customer.temporary_local_body_id.exists' => __('The selected temporary local body is invalid.'),
            'customer.temporary_ward.integer' => __('The temporary ward must be an integer.'),
            'customer.temporary_tole.string' => __('The temporary tole must be a string.'),
            'customer.document_type.required' => __('The document type is required.'),
            'customer.document_type.string' => __('The document type must be a string.'),
            'customer.document_issued_at.required' => __('The document issued at field is required.'),
            'customer.document_issued_at.string' => __('The document issued at must be a string.'),
            'customer.document_number.required' => __('The document number is required.'),
            'customer.document_number.string' => __('The document number must be a string.'),
            'uploadedImage1.required' => __('The uploaded image is required.'),
            'uploadedImage1.file' => __('The uploaded image1 must be a file.'),
            'uploadedImage1.mimes' => __('The uploaded image1 must be a file of type: jpg, jpeg, png, pdf.'),
            'uploadedImage1.max' => __('The uploaded image1 must not exceed 10 MB.'),
            'uploadedImage2.required' => __('The uploaded image is required.'),
            'uploadedImage2.file' => __('The uploaded image2 must be a file.'),
            'uploadedImage2.mimes' => __('The uploaded image2 must be a file of type: jpg, jpeg, png, pdf.'),
            'uploadedImage2.max' => __('The uploaded image2 must not exceed 10 MB.'),
            'customer.expiry_date_english.date' => __('The English expiry date must be a valid date.'),
            'customer.document_issued_date_nepali' => __('The document issued date nepali field is required.')
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

        return view("Customers::livewire.form", ['genderOptions' => $genderOptions, 'documentOptions' => $documentOptions, 'provinces' => $this->provinces]);
    }

    public function permanentLoadDistricts()
    {
        $this->permanentDistricts = getDistricts($this->customer['permanent_province_id'])->pluck('title', 'id')->toArray();

        $this->permanentLocalBodies = [];
        $this->permanentWards = [];
    }
    public function temporaryLoadDistricts()
    {
        $this->temporaryDistricts = getDistricts($this->customer['temporary_province_id'])->pluck('title', 'id')->toArray();

        $this->temporaryLocalBodies = [];
        $this->temporaryWards = [];
    }

    public function permanentLoadLocalBodies(): void
    {
        $this->permanentLocalBodies = getLocalBodies(district_ids: $this->customer['permanent_district_id'])->pluck('title', 'id')->toArray();

        $this->permanentWards = [];
    }
    public function temporaryLoadLocalBodies(): void
    {
        $this->temporaryLocalBodies = getLocalBodies(district_ids: $this->customer['temporary_district_id'])->pluck('title', 'id')->toArray();

        $this->temporaryWards = [];
    }

    public function temporaryLoadWards(): void
    {
        $this->temporaryWards = getWards(getLocalBodies(localBodyId: $this->customer['temporary_local_body_id'])->wards);
    }
    public function permanentLoadWards(): void
    {
        $this->permanentWards = getWards(getLocalBodies(localBodyId: $this->customer['permanent_local_body_id'])->wards);
    }

    public function mount(Customer $customer, Action $action, bool $isModalForm, bool $isForGrievance = false)
    {
        $this->customer = $customer;
        $this->action = $action;
        $this->isModalForm = $isModalForm;
        $this->isForGrievance = $isForGrievance;
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
            if (!$this->isForGrievance) {
                $this->processCustomerData();
            }

            $this->customer->password = Str::random(10);

            $dto = CustomerAdminDto::fromAdminLiveWireModel($this->customer);
            $service = new CustomerAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $this->isForGrievance ?  $service->storecustomer($dto) : $service->store($dto);

                    $this->successFlash(__("Customer Created Successfully"));
                    if (!$this->isModalForm) {
                        return redirect()->route('admin.customer.index');
                    } else {
                        $this->dispatch('customer-created');
                    }
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    private function processCustomerData()
    {
        $this->initializeDates(
            $this->customer['nepali_date_of_birth'],
            $this->customer['document_issued_date_nepali'],
            $this->customer['expiry_date_english']
        );

        if ($this->isSameAsPermanent) {
            $this->copyPermanentAddress();
        }

        $this->handleDocumentUploads();
    }

    private function copyPermanentAddress()
    {
        $this->customer->temporary_province_id = $this->customer->permanent_province_id;
        $this->customer->temporary_district_id = $this->customer->permanent_district_id;
        $this->customer->temporary_local_body_id = $this->customer->permanent_local_body_id;
        $this->customer->temporary_ward = $this->customer->permanent_ward;
        $this->customer->temporary_tole = $this->customer->permanent_tole;
    }

    private function handleDocumentUploads()
    {
        $this->customer->document_image1 = $this->uploadedImage1 ? $this->handleFileUpload($this->uploadedImage1) : null;
        $this->customer->document_image2 = $this->uploadedImage2 ? $this->handleFileUpload($this->uploadedImage2) : null;
    }

    public function handleFileUpload($file)
    {
        // Use the new local-first upload strategy
        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            // Store locally first, then queue transfer to cloud storage
            $path = \App\Services\LivewireFileService::handleTemporaryFile(
                file: $file,
                targetPath: config('src.CustomerKyc.customerKyc.path'),
                transferToCloud: true,
                modelClass: \Src\Customers\Models\Customer::class,
                modelId: $this->customer->id ?? null,
                modelField: null // Will be set after customer is saved
            );
            return $path ? basename($path) : null;
        }
        
        // Fallback to original method for non-Livewire files - use proper storage disk
        return FileFacade::saveFile(config('src.CustomerKyc.customerKyc.path'), "", $file, getStorageDisk('private'));
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        $this->customer->name = $result['name'];
        $this->customer->mobile_no = $result['mobile_no'];
        $this->customer->email = $result['email'];
        $this->customer->gender = $result['gender'];
    }

    private function initializeDates(string | null $nepaliDob, string | null $nepaliDocIssuedDate, string | null $engExpiryDate): void
    {
        $this->customer['english_date_of_birth'] = $nepaliDob != null ? $this->bsToAd($nepaliDob) : null;
        $this->customer['document_issued_date_english'] = $nepaliDocIssuedDate != null ? $this->bsToAd($nepaliDocIssuedDate) : null;
        $this->customer['expiry_date_nepali'] = $engExpiryDate != null ? $this->adToBs($engExpiryDate) : null;
    }

    public function updateDocumentNumber()
    {
        if (
            $this->customer['document_type'] === "national_id" ||
            $this->customer['document_type'] === "citizenship"
        ) {
            $this->showDocumentBackInput = true;
        } else {
            $this->showDocumentBackInput = false;
        }
    }
}
