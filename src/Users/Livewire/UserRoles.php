<?php

namespace Src\Users\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Src\Roles\Service\RoleAdminService;

class UserRoles extends Component
{
    public ?User $user;
    public $roles;

    public function render(){
        return view('Users::livewire.roles',[
            'roles' =>$this->roles
        ]);
    }

    public function mount(User $user){
        $this->user = $user;
        $this->roles = Role::where('name', '!=', 'super-admin')->get();
    }

    public function toggleRole($roleId,$userId){
        $service = new RoleAdminService();
        $service->toggleUserRole($userId,$roleId);
    }
}
