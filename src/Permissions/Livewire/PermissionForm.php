<?php

namespace Src\Permissions\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Permissions\DTO\PermissionAdminDto;
use Src\Permissions\Models\Permission;
use Src\Permissions\Service\PermissionAdminService;

class PermissionForm extends Component
{
    use SessionFlash;

    public ?Permission $permission;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'permission.name' => ['required'],
            'permission.guard_name' => ['required'],
        ];
    }

    public function render()
    {
        return view("Permissions::livewire.form");
    }

    public function mount(Permission $permission, Action $action)
    {
        $this->permission = $permission;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = PermissionAdminDto::fromLiveWireModel($this->permission);
            $service = new PermissionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Permission Created Successfully"));
//                    return redirect()->route('admin.permissions.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->permission, $dto);
                    $this->successFlash(__("Permission Updated Successfully"));
//                    return redirect()->route('admin.permissions.index');
                    break;
                default:
                    return redirect()->route('admin.permissions.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
