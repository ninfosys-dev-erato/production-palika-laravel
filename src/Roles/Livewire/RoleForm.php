<?php

namespace Src\Roles\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Roles\DTO\RoleAdminDto;
use Src\Roles\Models\Role;
use Src\Roles\Service\RoleAdminService;

class RoleForm extends Component
{
    use SessionFlash;

    public ?Role $role;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'role.name' => ['required'],
            'role.guard_name' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'role.name.required' => __('The role name field is required.'),
            'role.guard_name.required' => __('The guard name field is required.'),
        ];
    }


    public function render()
    {
        return view("Roles::livewire.form");
    }

    public function mount(Role $role, Action $action)
    {
        $this->role = $role;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = RoleAdminDto::fromLiveWireModel($this->role);
            $service = new RoleAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Role Created Successfully"));
                    return redirect()->route('admin.roles.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->role, $dto);
                    $this->successFlash(__("Role Updated Successfully"));
                    return redirect()->route('admin.roles.index');
                    break;
                default:
                    return redirect()->route('admin.roles.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
