<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Facades\FileFacade;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\Grievance\Models\GrievanceType;
use Src\Grievance\Service\v3\GrievanceService;

class GuansoForm extends Component
{
    use SessionFlash, HelperDate;

    use WithFileUploads;
    public $branch_id;
    public $grievance_type_id;
    public $subject;
    public $description;
    public bool $is_public;
    public bool $is_anonymous;
    public  $files = [];
    public  $branches = [];
    public  $types = [];
    protected $domainGrievanceService;
    public ?Action $action;
    public $admin;
    public $customer_id;
    public $customerID;
    public $uploadedImage;
    public bool $is_ward = true;
    public bool $showCustomerKycModal = false;
    public ?bool $isModalForm;
    public $selectedDepartments = [];
    public function mount()
    {
        $this->branches = Branch::all(['id', 'title'])
            ->mapWithKeys(fn($branch) => [$branch->id => $branch->title])
            ->toArray();

        $this->types = GrievanceType::all(['id', 'title'])
            ->mapWithKeys(fn($type) => [$type->id => $type->title])
            ->toArray();

        $this->admin = $this->admin ?? false;
        $this->isModalForm = true;
    }

    public function rules()
    {
        return [
            'grievance_type_id' => ['required', Rule::exists('gri_grievance_types', 'id')],
            'customer_id' => ['required'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_public' => ['nullable', 'boolean'],
            'is_anonymous' => ['nullable', 'boolean'],
            'is_ward' => ['nullable', 'boolean'],
            'uploadedImage' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => __('grievance::grievance.customer_detail_is_required'),
            'grievance_type_id.required' => __('grievance::grievance.the_grievance_type_is_required'),
            'grievance_type_id.exists' => __('grievance::grievance.the_selected_grievance_type_is_invalid'),
            'branch_id.exists' => __('grievance::grievance.the_selected_branch_is_invalid'),
            'branch_id.required' => __('grievance::grievance.the_branch_id_field_is_required'),
            'subject.required' => __('grievance::grievance.the_subject_field_is_required'),
            'subject.string' => __('grievance::grievance.the_subject_must_be_a_string'),
            'subject.max' => __('grievance::grievance.the_subject_must_not_exceed_255_characters'),
            'description.required' => __('grievance::grievance.the_description_field_is_required'),
            'description.string' => __('grievance::grievance.the_description_must_be_a_string'),
            'is_public.boolean' => __('grievance::grievance.the_is_public_field_must_be_true_or_false'),
            'is_anonymous.boolean' => __('grievance::grievance.the_is_anonymous_field_must_be_true_or_false'),
            'is_ward.boolean' => __('grievance::grievance.the_field_must_be_true_or_false'),
            'files.array' => __('grievance::grievance.the_files_must_be_an_array'),
            'files.*.string' => __('grievance::grievance.each_file_must_be_a_string'),
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.customer.gunaso-form");
    }

    public function openCustomerKycModal()
    {
        $this->showCustomerKycModal = true;
    }

    public function closeCustomerKycModal()
    {
        $this->showCustomerKycModal = false;
    }

    public function updatedCustomerId($value)
    {
        $this->customerID = $value;
    }

    public function save()
    {
        $this->validate();
        $validatedData = $this->validate();
        $customer = null;

        $customer = Customer::findOrFail ($this->customerID);

        // try{
            $data = $this->getValidatedData();
            $dto = GrievanceDto::fromValidatedRequest($data);
            $grievanceService = new GrievanceService();
            $grievanceService->create($dto, $customer);
            $this->successFlash(__('grievance::grievance.grievance_created_successfully'));

            if ($this->admin) {
                return redirect()->route('admin.grievance.grievanceDetail.index');
            }
            return redirect(url('customer/grievances'));
        // }catch (\Throwable $e){
        //     dd($e->getMessage());
        //     logger($e->getMessage());
        //    $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        // }
    }
    
    private function getValidatedData(): array
    {
        $this->is_anonymous = $this->is_anonymous ?? false;
        $this->is_public = $this->is_anonymous === false ? true : false;

        $data = [
            'grievance_type_id' => $this->grievance_type_id,
            'branch_id' => $this->selectedDepartments,
            'subject' => $this->subject,
            'description' => $this->description,
            'is_public' => $this->is_public ?? false,
            'is_anonymous' => $this->is_anonymous ?? false,
            'is_ward' => $this->is_ward ?? false,
        ];

        if ($this->uploadedImage) {
            $storedDocuments = [];

            foreach ($this->uploadedImage as $file) {
                $fileExtension = strtolower($file->getClientOriginalExtension());
                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                
            
                    // Use ImageServiceFacade for images
                    if ($this->is_public == true) {
                        // $path = ImageServiceFacade::compressAndStoreImage($file, config('src.Grievance.grievance.path'), getStorageDisk('public'));
                        $path = FileFacade::saveFile(config('src.Grievance.grievance.path'), '', $file, getStorageDisk('public'));

                    } else {
                        // $path = ImageServiceFacade::compressAndStoreImage($file, config('src.Grievance.grievance.path'), getStorageDisk('private'));
                        $path = FileFacade::saveFile(config('src.Grievance.grievance.path'), '', $file, getStorageDisk('private'));
                    }
             

                $storedDocuments[] = $path;
            }
            $data['files'] = $storedDocuments;
        }
        return $data;
    }
}
