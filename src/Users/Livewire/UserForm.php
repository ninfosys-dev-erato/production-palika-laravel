<?php

namespace Src\Users\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Rules\MobileNumberIdentifierRule;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use App\Facades\ImageServiceFacade;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Users\DTO\UserAdminDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Src\Address\Models\LocalBody;
use Src\Employees\Models\Branch;
use Src\Roles\Models\Role;
use Src\Settings\Models\Setting;
use Src\Users\DTO\UserDepartmentDto;
use Src\Users\DTO\UserRoleDto;
use Src\Users\DTO\UserWardDto;
use Src\Users\Models\UserWard;
use Src\Users\Service\UserAdminService;

class UserForm extends Component
{
    use SessionFlash, HelperDate, WithFileUploads;

    public $user_password;
    public ?User $user;
    public ?Action $action;
    public $selectedward; //selected wards taken from url
    public int $local_body_id;
    public $wards = [];
    public $selected_wards = [];
    public $roles = [];
    public $selectedRoles = [];
    public array $departments = [];
    public array $selectedDepartments = [];
    public array $departmentHeads = [];
    public bool $fromWard = false;
    public $userSignature;
    public $userSignatureUrl;
    public $uploadedSignaturePath; // Store the uploaded file path

    public function rules(): array
    {
        $rules = [
            'user.name' => ['required'],
            'user.email' => ["required", "email"],
            'user.mobile_no' => ['nullable', 'string', 'max:10', 'unique:users,mobile_no'],
            'selected_wards' => ['nullable', 'array'],
            'userSignature' => ['nullable', 'image'],
        ];

        if ($this->action == Action::CREATE) {
            $rules['user.email'] = "unique:users,email|required";
            $rules['user_password'] = ['required', 'min:6'];
        } elseif ($this->action == Action::UPDATE) {
            $rules['user.email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ];
            // Remove unique check for mobile_no when updating:
            $rules['user.mobile_no'] = ['nullable', 'string', 'max:10'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user.name.required' => __('users::users.the_name_field_is_required'),
            'user.email.required' => __('users::users.the_email_field_is_required'),
            'user.email.email' => __('users::users.the_email_must_be_a_valid_email_address'),
            'user.mobile_no.required' => __('users::users.the_mobile_number_field_is_required'),
            'user.mobile_no.max' => __('users::users.the_mobile_number_must_be_10_digits'),
            'user.mobile_no.string' => __('users::users.the_mobile_number_must_be_a_string'),
            'selected_wards.nullable' => __('users::users.the_selected_wards_field_can_be_null'),
            'user_password.required' => __('users::users.the_password_field_is_required'),
            'user_password.min' => __('users::users.the_password_must_be_at_least_6_characters'),
            'user.email.unique' => __('users::users.the_email_has_already_been_taken'),
            'user.mobile_no.unique' => __('users::users.the_mobile_number_has_already_been_taken'),
            'userSignature.image' => __('users::users.the_signature_must_be_an_image'),
        ];
    }

    public function render()
    {
        return view("Users::livewire.form");
    }

    public function mount(User $user, Action $action, $id = null, $selectedward = null)
    {
        $this->selectedward = $selectedward; //assigning so that user created from specific ward is selected
        $this->user = $user;
        $this->action = $action;
        $this->roles = Role::where('name', '!=', 'super-admin')
            ->pluck('name', 'id')
            ->toArray();
        $this->departments = Branch::select('id', 'title', 'title_en')->get()->toArray();
        $this->selectedDepartments = $user->departments->pluck('id')->toArray() ?? [];
        $this->departmentHeads = $user->departments
            ->pluck('pivot.is_department_head', 'id')
            ->map(fn($value) => (bool)$value)
            ->toArray() ?? [];
        $this->local_body_id = key(getSettingWithKey('palika-local-body'));
        $localBody = $this->local_body_id ? LocalBody::find($this->local_body_id) : null;

        $this->wards = $localBody ? getWards($localBody->wards) : [];

        if ($selectedward) { //checks ward and assigns ward in create form 
            $this->selected_wards = (array) $this->selectedward;
            $this->fromWard = !$this->fromWard;
        }

        if ($user->id) {
            $this->selected_wards = UserWard::where('user_id', $user->id)
                ->pluck('ward')
                ->toArray();
            $this->selectedRoles = $user->roles()?->pluck('id')->toArray();
        }
        if ($this->action == Action::UPDATE) {
            $this->handleFileUpload(null, 'signature', 'userSignatureUrl');
        }
    }

    public function updatedUserSignature()
    {

        $this->handleFileUpload($this->userSignature, 'signature', 'userSignatureUrl');
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Profile.profile.path'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );

            // Store the uploaded file path in a separate property
            $this->uploadedSignaturePath = $save;

            $this->user->{$modelField} = $save;
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Profile.profile.path'),
                filename: $save,
                disk: getStorageDisk('private')
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->user->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Profile.profile.path'),
                    filename: $this->user->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }


    public function save()
    {

        $this->validate();
        $this->user->mobile_no = $this->convertNepaliToEnglish($this->user->mobile_no);


        if ($this->uploadedSignaturePath) {
            $this->user->signature = $this->uploadedSignaturePath;
        }


        if (!empty($this->user_password)) {
            $this->user->password = $this->user_password;
        }


        $dto = UserAdminDto::fromLiveWireModel($this->user);
        $wardDtos = UserWardDto::fromInputs($this->local_body_id, $this->selected_wards);
        $departmentDtos = UserDepartmentDto::fromInputs($this->selectedDepartments, $this->departmentHeads);
        $roleDtos = UserRoleDto::fromInputs($this->selectedRoles);


        $service = new UserAdminService();
        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $user = $service->store($dto);
                    $service->saveUserWard($user, $wardDtos);
                    $service->saveUserDepartments($user, $departmentDtos);
                    $service->saveUserRoles($user, $roleDtos);
                    DB::commit();
                    $this->successFlash(__('users::users.user_created_successfully'));
                    return $this->fromWard
                        ? redirect()->route('admin.wards.showusers', ['id' => $this->selectedward])
                        : redirect()->route('admin.users.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->user, $dto);
                    $service->saveUserWard($this->user, $wardDtos);
                    $service->saveUserDepartments($this->user, $departmentDtos);
                    $service->saveUserRoles($this->user, $roleDtos);

                    DB::commit();
                    $this->successFlash(__('users::users.user_updated_successfully'));
                    // return redirect()->back();
                    return $this->fromWard
                        ? redirect()->route('admin.wards.showusers', ['id' => $this->selectedward])
                        : redirect()->route('admin.users.index');

                    break;

                default:
                    return $this->redirect(url()->previous());
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->addError('department_head', $e->getMessage());
        }
    }
}
