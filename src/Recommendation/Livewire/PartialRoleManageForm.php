<?php

namespace Src\Recommendation\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\Recommendation\Models\Recommendation;
use Src\Roles\Models\Role;

class PartialRoleManageForm extends Component
{
    use SessionFlash;

    public ?Recommendation $recommendation;
    public Action $action;
    public $roles = [];

    #[Modelable]
    
    public $selectedRoles = [];
    public $create = false;

    public function mount(Recommendation $recommendation, Action $action)
    {
        $this->recommendation = $recommendation;
        $this->action = $action;
        $this->roles = Role::where('name', '!=', 'super-admin')->get();
        $this->selectedRoles = $this->recommendation->roles?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Recommendation::livewire.recommendation.partial-manage-notifee", [
            'recommendation' => $this->recommendation,
        ]);
    }

}