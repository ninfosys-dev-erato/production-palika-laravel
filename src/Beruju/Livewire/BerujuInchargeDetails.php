<?php

namespace Src\Beruju\Livewire;

use Livewire\Component;
use Src\Beruju\Models\BerujuEntry;
use Livewire\Attributes\On;

class BerujuInchargeDetails extends Component
{
    public BerujuEntry $berujuEntry;
    public bool $showInchargeDetails = false;

    public function mount(BerujuEntry $berujuEntry)
    {
        $this->berujuEntry = $berujuEntry;
        $this->showInchargeDetails = $berujuEntry->resolutionCycles && $berujuEntry->resolutionCycles->count() > 0;
    }

    #[On('show-incharge-details')]
    public function toggleToInchargeDetails()
    {
        $this->showInchargeDetails = true;
        $this->berujuEntry->refresh();
    }

    public function toggleToForm()
    {
        $this->showInchargeDetails = false;
    }

    public function render()
    {
        return view('Beruju::livewire.beruju-incharge-details');
    }
}
