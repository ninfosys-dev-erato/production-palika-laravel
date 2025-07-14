<?php

namespace Src\Users\Livewire;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{
    public ?User $user;

    public function mount(User $user)
    {
        $this->user = $user->load([
            'departments',
            'departments',
            'userWards.localBody'
        ]);

    }

    public function render()
    {
        return view('Users::livewire.user-details', [
            'user' => $this->user,
        ]);
    }
}
