<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Facades\GlobalFacade;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class SigneeSelect extends Component
{
    public $wards;
    public $departments;
    public $users;
    public $selectedUserId;
    public function mount($selectedUserId = 0, array $wards = [], array $departments = [])
    {
        $this->wards = $wards;
        if (empty($wards)) {
            $this->wards = [GlobalFacade::ward()];
        }
        $this->departments = collect($this->departments)->pluck('id')->toArray();
        $this->selectedUserId = $selectedUserId;
        $this->users = User::whereHas('userWards', function ($query) {
            $query->whereIn('ward', $this->wards);
        })

            ->orWhereHas('departments', function ($query) {
                $query->whereIn('mst_branches.id', $this->departments);
            })
            ->get();
    }
    public function render()
    {
        return view('livewire.signee-select');
    }

    public function selectSignee(User $user)
    {
        $this->selectedUserId = $user->id;
        $this->dispatch('signee-selected', signee: $user->id);
    }
    #[On('assign-ward')]
    public function assignWard() {}
    #[On('assign-department')]
    public function addDepartment() {}
    #[On('clear-ward')]
    public function clearWard()
    {
        $this->wards = [];
    }
    #[On('clear-department')]
    public function clearDepartment()
    {
        $this->departments = [];
    }
}
