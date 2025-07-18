<?php

namespace App\Livewire;

use App\Facades\GlobalFacade;
use Livewire\Component;

class WardSwitcher extends Component
{
    protected $listeners = ['changeWard'];
    
    public $ward;

    public function mount()
    {
        $this->ward = GlobalFacade::ward();
    }

    public function changeWard(int $ward)
    {
       GlobalFacade::ward($ward);
        $this->dispatch('ward-change');
    }

    public function render()
    {
        return view('livewire.ward-switcher');
    }
}
