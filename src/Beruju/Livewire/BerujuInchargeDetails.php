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
    
    #[On('incharge-updated')]
    public function refreshInchargeDetails()
    {
        $this->berujuEntry->refresh();
    }

    public function toggleToForm()
    {
        $this->showInchargeDetails = false;
    }

    public function render()
    {
        // Load the resolution cycles with their relationships
        $this->berujuEntry->load([
            'resolutionCycles' => function($query) {
                $query->where('status', 'active')
                      ->with(['incharge', 'assignedBy']);
            }
        ]);
        
        // Get only the latest active resolution cycle from the loaded collection
        $latestCycle = $this->berujuEntry->resolutionCycles
            ->where('status', 'active')
            ->sortByDesc('id')
            ->first();
            
        return view('Beruju::livewire.beruju-incharge-details', compact('latestCycle'));
    }
}
