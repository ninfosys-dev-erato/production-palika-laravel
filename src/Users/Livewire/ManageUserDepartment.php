<?php

namespace Src\Users\Livewire;

use App\Models\User;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Users\DTO\UserDepartmentDto;
use Src\Users\Service\UserAdminService;

class ManageUserDepartment extends Component
{
    use SessionFlash;

    public ?User $user;
    public array $departments = [];
    public array $selectedDepartments = [];
    public array $departmentHeads = [];


    public function mount(User $user)
    {
        $this->initializeValues($user);
    }

    public function render()
    {
        return view("Users::livewire.manage-departments");
    }

    public function saveDepartments(UserAdminService $service)
    {
        try {
            $userDepartmentDtos = UserDepartmentDto::fromInputs(
                $this->selectedDepartments,
                $this->departmentHeads
            );

            $service->saveUserDepartments($this->user, $userDepartmentDtos);

            $this->successFlash(__('users::users.departments_assigned_successfully'));
            return redirect()->route('admin.users.manage', ['id' => $this->user->id]);
        } catch (\Exception $e) {
            $this->addError('department_head', $e->getMessage());
        }
    }

    public function initializeValues(User $user)
    {
        $this->user = $user;
        $this->departments = Branch::select('id', 'title', 'title_en')->get()->toArray();


        $this->selectedDepartments = $user->departments->pluck('id')->toArray() ?? [];
        $this->departmentHeads = $user->departments
            ->pluck('pivot.is_department_head', 'id')
            ->map(fn($value) => (bool)$value)
            ->toArray() ?? [];
    }
}
