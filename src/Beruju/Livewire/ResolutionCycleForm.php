<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use App\Enums\Action;
use Src\Beruju\DTO\ResolutionCycleAdminDto;
use Src\Beruju\Models\ResolutionCycle;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Service\ResolutionCycleAdminService;
use App\Models\User;
use Livewire\Attributes\On;

class ResolutionCycleForm extends Component
{
    use SessionFlash;

    public ?ResolutionCycle $resolutionCycle;
    public ?Action $action = Action::CREATE;
    public $berujuEntries;
    public $users;

    public function rules(): array
    {
        return [
            'resolutionCycle.beruju_id' => ['required', 'exists:brj_beruju_entries,id'],
            'resolutionCycle.incharge_id' => ['required', 'exists:users,id'],
            'resolutionCycle.remarks' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'resolutionCycle.beruju_id.required' => __('beruju::beruju.beruju_entry_required'),
            'resolutionCycle.beruju_id.exists' => __('beruju::beruju.selected_beruju_entry_not_exist'),
            'resolutionCycle.incharge_id.required' => __('beruju::beruju.incharge_required'),
            'resolutionCycle.incharge_id.exists' => __('beruju::beruju.selected_incharge_not_exist'),
            'resolutionCycle.assigned_by.required' => __('beruju::beruju.assigned_by_required'),
            'resolutionCycle.assigned_by.exists' => __('beruju::beruju.selected_assigned_by_not_exist'),
            'resolutionCycle.assigned_at.required' => __('beruju::beruju.assigned_at_required'),
            'resolutionCycle.assigned_at.date' => __('beruju::beruju.assigned_at_must_be_valid_date'),
            'resolutionCycle.status.required' => __('beruju::beruju.status_required'),
            'resolutionCycle.status.in' => __('beruju::beruju.status_invalid'),
            'resolutionCycle.remarks.string' => __('beruju::beruju.remarks_must_be_string'),
            'resolutionCycle.completed_at.date' => __('beruju::beruju.completed_at_must_be_valid_date'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.resolution-cycle-form");
    }

    public function mount(ResolutionCycle $resolutionCycle = null, Action $action = Action::CREATE, $berujuEntry = null)
    {
       
        $this->resolutionCycle = $resolutionCycle ?? new ResolutionCycle();
        $this->action = $action;
        $this->users = User::whereNull('deleted_at')->pluck('name', 'id');
        
        if ($this->action === Action::CREATE) {
            
            // Pre-fill beruju_id if provided
            if ($berujuEntry) {
                $this->resolutionCycle->beruju_id = $berujuEntry->id;
            }
            
            // Set default values for required fields
            $this->resolutionCycle->assigned_by = auth()->id(); // Current user
            $this->resolutionCycle->assigned_at = now()->format('Y-m-d\TH:i');
            
        }
    }

    public function save()
    {
        try {
            $this->validate();
            $this->resolutionCycle->status = 'active';
            $dto = ResolutionCycleAdminDto::fromLiveWireModel($this->resolutionCycle);
            $service = new ResolutionCycleAdminService();
        
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('beruju::beruju.beruju_assigned_successfully'));
                $this->dispatch('close-modal');
                $this->dispatch('show-incharge-details');
                break;
            case Action::UPDATE:
                $service->update($this->resolutionCycle, $dto);
                $this->successFlash(__('beruju::beruju.beruju_updated_successfully'));
                $this->dispatch('close-modal');
                $this->dispatch('show-incharge-details');
                break;
            default:
                break;
        }
        } catch (\Exception $e) {
            $this->errorFlash($e->getMessage());
        }
    }

    #[On('edit-resolution-cycle')]
    public function editResolutionCycle(ResolutionCycle $resolutionCycle)
    {
        $this->resolutionCycle = $resolutionCycle;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetResolutionCycle()
    {
        // Store the beruju_id before resetting
        $berujuId = $this->resolutionCycle->beruju_id;
        
        $this->reset(['resolutionCycle', 'action']);
        $this->resolutionCycle = new ResolutionCycle();
        $this->action = Action::CREATE;
        
        // Restore the beruju_id
        $this->resolutionCycle->beruju_id = $berujuId;
        
        // Set default values for required fields
        $this->resolutionCycle->assigned_by = auth()->id();
        $this->resolutionCycle->assigned_at = now()->format('Y-m-d\TH:i');
        $this->resolutionCycle->status = 'active';
    }
}
