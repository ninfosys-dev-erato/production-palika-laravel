<?php

namespace Src\Employees\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Models\User;
use App\Rules\MobileNumberIdentifierRule;
use App\Services\ImageService;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Employees\DTO\EmployeeAdminDto;
use Src\Employees\Enums\GenderEnum;
use Src\Employees\Enums\TypeEnum;
use Src\Employees\Models\Employee;
use Src\Employees\Service\EmployeeAdminService;
use Src\Roles\Models\Role;
use Src\Users\DTO\UserAdminDto;
use Src\Users\DTO\UserRoleDto;
use Src\Users\Service\UserAdminService;
use Src\Employees\Models\Branch;

class EmployeeForm extends Component
{
    use SessionFlash, HelperDate;
    use WithFileUploads;
    public ?Employee $employee;
    public ?User $user;
    public ?Action $action;
    public $uploadedImage;
    public array $genders = [];
    public array $types = [];
    public bool $is_department_head = false;
    public array $roles = [];
    public array $selectedRoles = [];
    public string $user_password;
    public bool $isUser = false;
    public $branchName;
    public $previousUrl;
    public $wards = [];

    public function rules(): array
    {
        $rules = [
            'employee.name' => ['required'],
            'employee.address' => ['required'],
            'employee.gender' => ['required'],
            'employee.pan_no' => ['nullable'],
            'employee.is_department_head' => ['nullable'],
            'employee.email' => [
                'nullable',
                'email',
                Rule::unique('mst_employees', 'email')->where(fn($query) => $query->whereNull('deleted_at'))
            ],
            'employee.phone' => ['required', new MobileNumberIdentifierRule(), Rule::unique('mst_employees', 'phone')
                ->ignore($this->employee->id)
                ->whereNull('deleted_at'),],
            'employee.type' => ['nullable', new Enum(TypeEnum::class)],
            'employee.position' => ['nullable', 'integer'],
            'employee.remarks' => ['nullable'],
            'employee.branch_id' => ['nullable'],
            'employee.ward_no' => ['nullable'],
            'employee.designation_id' => ['nullable'],
        ];
        if ($this->action === Action::CREATE) {
            $rules['uploadedImage'] = ['required', 'image', 'mimes:jpeg,png,bmp,gif,svg,webp'];  // Must be a GIF
            if ($this->isUser) {
                $rules['user_password'] = ['required', 'min:6'];
                $rules['employee.phone'] = ['required', Rule::unique('users', 'mobile_no')->whereNull('deleted_at')];
                $rules['employee.email'] = ['required', Rule::unique('users', 'email')->whereNull('deleted_at')];
            }
        } else {
            $rules['employee.email'] = [
                'nullable',
                'email',
                Rule::unique('mst_employees', 'email')->ignore($this->employee->id),
            ];
            $rules['employee.phone'] = [
                'nullable',
                Rule::unique('mst_employees', 'phone')->ignore($this->employee->id),
            ];
            $rules['uploadedImage'] = ['nullable', 'image', 'mimes:jpeg,png,bmp,gif,svg,webp'];  // Optional but only GIFs

            if ($this->isUser) {
                $rules['user_password'] = ['required', 'min:6'];
                $rules['employee.phone'] = [
                    'required',
                    Rule::unique('mst_employees', 'phone')->ignore($this->employee->id),
                    Rule::unique('users', 'mobile_no')
                        ->ignore($this->employee->user_id)
                        ->where(fn($query) => $query->whereNull('deleted_at'))
                ];
                $rules['employee.email'] = [
                    'required',
                    'email',
                    Rule::unique('mst_employees', 'email')->ignore($this->employee->id),
                    Rule::unique('users', 'email')->ignore($this->employee->user_id)
                        ->where(fn($query) => $query->whereNull('deleted_at'))
                ];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'employee.name.required' => __('employees::employees.the_employee_name_is_required'),
            'employee.address.required' => __('employees::employees.the_employee_address_is_required'),
            'employee.gender.required' => __('employees::employees.the_employee_gender_is_required'),
            'employee.pan_no.nullable' => __('employees::employees.the_pan_number_is_optional'),
            'employee.is_department_head.nullable' => __('employees::employees.the_department_head_status_is_optional'),
            'employee.email.required' => __('employees::employees.the_email_address_is_required'),
            'employee.email.email' => __('employees::employees.the_email_must_be_a_valid_email_address'),
            'employee.phone.required' => __('employees::employees.the_phone_number_is_required'),
            'employee.phone.mobile_number_identifier' => __('employees::employees.the_phone_number_is_not_valid'),
            'employee.type.nullable' => __('employees::employees.the_type_is_optional'),
            'employee.type.enum' => __('employees::employees.the_type_must_be_one_of_the_valid_options'),
            'employee.position.nullable' => __('employees::employees.the_position_is_optional'),
            'employee.position.integer' => __('employees::employees.the_position_must_be_a_valid_integer'),
            'employee.remarks.nullable' => __('employees::employees.the_remarks_are_optional'),
            'employee.branch_id.nullable' => __('employees::employees.the_branch_id_is_optional'),
            'employee.branch_id.exists' => __('employees::employees.the_selected_branch_is_invalid'),
            'employee.ward_no.nullable' => __('employees::employees.the_ward_number_is_optional'),
            'employee.designation_id.nullable' => __('employees::employees.the_designation_id_is_optional'),
            'employee.designation_id.exists' => __('employees::employees.the_selected_designation_is_invalid'),
            'uploadedImage.required' => __('employees::employees.the_uploaded_image_is_required'),
            'uploadedImage.image' => __('employees::employees.the_uploaded_file_must_be_an_image'),
            'uploadedImage.mimes' => __('employees::employees.the_image_must_be_of_type_jpeg_png_bmp_gif_svg_or_webp'),
            'uploadedImage.nullable' => __('employees::employees.the_uploaded_image_is_optional')
        ];
    }

    public function render()
    {
        return view("Employees::livewire.employee.form");
    }

    public function mount(Employee $employee, Action $action, $branchName = null): void
    {
        $this->branchName = $branchName ?? '';
        $this->employee = $employee;
        $this->action = $action;
        $this->previousUrl = session()->get('previousUrl', url()->previous());
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);

        if (!empty($this->branchName)) {
            $branch = Branch::where('title_en', $this->branchName)->first();
            if ($branch) {
                $this->employee->branch_id = $branch->id;
            }
        }
        $this->genders = GenderEnum::getForWeb();
        $this->types = TypeEnum::getForWeb();
        $this->roles = Role::where('name', '!=', 'super-admin')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function save()
    {

        $this->validate();
        $this->employee->phone = $this->convertNepaliToEnglish($this->employee->phone);
        $this->employee->position = $this->convertNepaliToEnglish($this->employee->position);

        $this->employee['is_department_head'] = $this->is_department_head;

        if ($this->uploadedImage) {
            $this->employee->photo = FileFacade::saveFile('team', '', $this->uploadedImage);
        }


        if ($this->isUser) {
            $this->user = $this->getUserData();
            $userDto = UserAdminDto::fromEmployeeLivewireModel($this->user);
            $roleDto = ! empty($this->selectedRoles) ?  UserRoleDto::fromInputs($this->selectedRoles) : [];
        }

        $service = new EmployeeAdminService();
        $userService = new UserAdminService();
        DB::beginTransaction();

        try {
            switch ($this->action) {
                case Action::CREATE:
                    if ($this->isUser) {
                        $user = $userService->store($userDto);
                        !empty($this->selectedRoles) && $userService->saveUserRoles(user: $user, userRoleDto: $roleDto);
                        $this->employee->user_id = $user->id;
                    }
                    $dto = EmployeeAdminDto::fromLiveWireModel($this->employee);
                    $service->store($dto);
                    $this->successFlash(__('employees::employees.employee_created_successfully'));
                    DB::commit();
                    return redirect()->to($this->previousUrl);


                case Action::UPDATE:

                    if ($this->isUser) {
                        $user = $userService->store($userDto);
                        !empty($this->selectedRoles) && $userService->saveUserRoles(user: $user, userRoleDto: $roleDto);
                        $this->employee->user_id = $user->id;
                    }
                    $dto = EmployeeAdminDto::fromLiveWireModel($this->employee);
                    $service->update($this->employee, $dto);
                    $this->successFlash(__('employees::employees.employee_updated_successfully'));
                    DB::commit();
                    return redirect()->to($this->previousUrl);
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
        }
    }

    public function updatedIsUser($value)
    {
        if ($value) {
            $this->dispatch('create-user');
        }
    }

    private function getUserData(): User
    {
        $user = new User();

        $user->name = $this->employee->name ?? '';
        $user->email = $this->employee->email ?? '';
        $user->mobile_no = $this->employee->phone ?? '';
        if (!empty($this->user_password)) {
            $user->password = $this->user_password;
        }

        return $user;
    }
}
