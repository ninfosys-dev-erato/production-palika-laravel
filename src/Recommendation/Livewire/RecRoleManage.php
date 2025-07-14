<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Recommendation\Models\Recommendation;
use Src\Roles\Models\Role;

class RecRoleManage extends Component
{
    use SessionFlash;


    public ?Recommendation $recommendation;
    public $roles = [];
    public $selectedRoles = [];

    public function mount(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
        $this->roles = Role::where('name', '!=', 'super-admin')->get();
        $this->selectedRoles = $this->recommendation->roles?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view("Recommendation::livewire.recommendation.manage-notifee", [
            'recommendation' => $this->recommendation,
        ]);
    }

    public function syncRoles()
    {
        $this->recommendation->roles()->sync($this->selectedRoles);
        $this->successFlash(__('recommendation::recommendation.notifee_have_been_synced_successfully'));
        return redirect()->route('admin.recommendations.recommendation.manage', ['id' => $this->recommendation->id]);
    }
}