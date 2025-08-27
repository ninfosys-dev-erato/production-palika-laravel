<?php

namespace Src\Beruju\Livewire;

use Livewire\Component;
use Src\Beruju\Models\BerujuEntry;
use Livewire\Attributes\On;

class ActionCard extends Component
{
    public BerujuEntry $berujuEntry;

    public function mount(BerujuEntry $berujuEntry)
    {
        $this->berujuEntry = $berujuEntry;
    }

    #[On('action-created')]
    #[On('action-updated')]
    #[On('incharge-updated')]
    public function refresh()
    {
        // Refresh the beruju entry data to get updated actions
        $this->berujuEntry = $this->berujuEntry->fresh([
            'resolutionCycles' => function($query) {
                $query->where('status', 'active')
                      ->with(['actions' => function($actionQuery) {
                          $actionQuery->with('actionType');
                      }, 'incharge', 'assignedBy']);
            }
        ]);
        
        // Force a re-render to update the view
        $this->dispatch('$refresh');
    }
    
    public function render()
    {
        // Ensure we always have the latest data with proper relationships loaded
        if ($this->berujuEntry) {
            // Load the resolution cycles with their actions and action types
            $this->berujuEntry->load([
                'resolutionCycles' => function($query) {
                    $query->where('status', 'active')
                          ->with(['actions' => function($actionQuery) {
                              $actionQuery->with('actionType');
                          }, 'incharge', 'assignedBy']);
                }
            ]);
        }
        
        return view('Beruju::livewire.action-card');
    }

    public function editAction($actionId)
    {
        // Dispatch the edit-action event to the ActionForm component
        $this->dispatch('edit-action', actionId: $actionId);
        
        // Also dispatch event to open the modal
        $this->dispatch('open-action-modal');
    }
}
