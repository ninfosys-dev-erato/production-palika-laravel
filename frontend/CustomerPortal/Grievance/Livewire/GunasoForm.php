<?php

namespace Frontend\CustomerPortal\Grievance\Livewire;

use App\Enums\Action;
use App\Facades\ActivityLogFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\Grievance\Models\GrievanceType;
use Src\Grievance\Service\v3\GrievanceService;

class GunasoForm extends Component
{
    use SessionFlash;
    use WithFileUploads;


    public $branch_id;
    public $grievance_type_id;
    public $subject;
    public $description;
    public $is_public;
    public $is_anonymous;
    public array $files = [];
    public array $branches = [];
    public array $types = [];
    protected $domainGrievanceService;
    public ?Action $action;
    public $admin;
    public $customer_id;
    public $uploadedImage;
    public bool $is_ward = true;
    public array $selectedDepartments = [];

    public function mount()
    {
       
        $this->branches = Branch::all(['id', 'title'])
            ->mapWithKeys(fn($branch) => [$branch->id => $branch->title])
            ->toArray();

        $this->types = GrievanceType::all(['id', 'title'])
            ->mapWithKeys(fn($type) => [$type->id => $type->title])
            ->toArray();

        $this->admin = $this->admin ?? false;
    }


    public function rules()
    {
        return [
            'grievance_type_id' => ['required', Rule::exists('gri_grievance_types', 'id')],
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
            'grievance_type_id.required' => __('The grievance type is required.'),
            'grievance_type_id.exists' => __('The selected grievance type is invalid.'),
            'branch_id.exists' => __('The selected branch is invalid.'),
            'branch_id.required' => __('The branch id field is required.'),
            'subject.required' => __('The subject field is required.'),
            'subject.string' => __('The subject must be a string.'),
            'subject.max' => __('The subject must not exceed 255 characters.'),
            'description.required' => __('The description field is required.'),
            'description.string' => __('The description must be a string.'),
            'is_public.boolean' => __('The is public field must be true or false.'),
            'is_ward.boolean' => __('The field must be true or false.'),
            'is_anonymous.boolean' => __('The is anonymous field must be true or false.'),
            'files.array' => __('The files must be an array.'),
            'files.*.string' => __('Each file must be a string.'),
        ];
    }


    public function render()
    {
        return view("CustomerPortal.Grievance::livewire.customer.gunaso-form");
    }

    public function save()
    {

        $this->validate();
        $customer = null;
        $customer = $this->admin ?Customer::where('id', $this->customer_id)->first() : auth('customer')->user(); 
    
        try{
            $data = $this->getValidatedData();
            $dto = GrievanceDto::fromValidatedRequest($data);
            $grievanceService = new GrievanceService();
            ActivityLogFacade::logForCustomer();
            $grievanceService->create($dto, $customer);
            $this->successFlash("Grievance Type Created Successfully");

            if ($this->admin) {
                return redirect()->route('admin.grievance.grievanceDetail.index');
            }
            return redirect(url('customer/grievances'));
        }catch (\Throwable $e){
            logger($e->getMessage());
            dd($e->getMessage());
           $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
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
            'customer_id' => $this->customer_id
        ];

        if ($this->uploadedImage) {
            $storedDocuments = [];

            foreach ($this->uploadedImage as $file) {
                if($this->is_public == true){
                    $path = ImageServiceFacade::compressAndStoreImage($file, config('src.Grievance.grievance.path'), getStorageDisk('public'));
                }
                else{
                    $path = ImageServiceFacade::compressAndStoreImage($file, config('src.Grievance.grievance.path'), getStorageDisk('private'));
                }
                $storedDocuments[] = $path;
            }
            $data['files'] = $storedDocuments;
        }
        return $data;
    }
}