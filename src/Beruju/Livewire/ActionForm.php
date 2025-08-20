<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use App\Enums\Action;
use Src\Beruju\DTO\ActionAdminDto;
use Src\Beruju\Models\Action as BerujuAction;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Models\ResolutionCycle;
use Src\Beruju\Models\ActionType;
use Src\Beruju\Service\ActionAdminService;
use Livewire\Attributes\On;

class ActionForm extends Component
{
    use SessionFlash;

    public ?BerujuAction $berujuAction;
    public ?Action $action = Action::CREATE;
    public $berujuEntry;
    public $latestCycle;
    public $actionTypes;

    public function rules(): array
    {
        return [
            'berujuAction.cycle_id' => ['required', 'exists:brj_resolution_cycles,id'],
            'berujuAction.action_type_id' => ['required', 'exists:brj_action_types,id'],
            'berujuAction.status' => ['required', 'in:Pending,Completed,Rejected'],
            'berujuAction.remarks' => ['nullable', 'string'],
            'berujuAction.resolved_amount' => ['nullable', 'numeric', 'min:0', 'max:9999999999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'berujuAction.cycle_id.required' => __('beruju::beruju.resolution_cycle_required'),
            'berujuAction.cycle_id.exists' => __('beruju::beruju.selected_resolution_cycle_not_exist'),
            'berujuAction.action_type_id.required' => __('beruju::beruju.action_type_required'),
            'berujuAction.action_type_id.exists' => __('beruju::beruju.selected_action_type_not_exist'),
            'berujuAction.status.required' => __('beruju::beruju.status_required'),
            'berujuAction.status.in' => __('beruju::beruju.status_invalid'),
            'berujuAction.remarks.string' => __('beruju::beruju.remarks_must_be_string'),
            'berujuAction.resolved_amount.numeric' => __('beruju::beruju.resolved_amount_must_be_numeric'),
            'berujuAction.resolved_amount.min' => __('beruju::beruju.resolved_amount_must_be_positive'),
            'berujuAction.resolved_amount.max' => __('beruju::beruju.resolved_amount_too_large'),
        ];
    }

    public function render()
    {
        // Always get the latest data when rendering
        if ($this->berujuEntry) {
            $this->berujuEntry->refresh();
            
            // Load the resolution cycles with their actions and action types
            $this->berujuEntry->load([
                'resolutionCycles' => function($query) {
                    $query->where('status', 'active')
                          ->whereNull('deleted_at')
                          ->with(['berujuEntry', 'incharge', 'actions' => function($actionQuery) {
                              $actionQuery->with('actionType');
                          }]);
                }
            ]);
            
            // Get the latest active resolution cycle from the loaded collection
            $latestCycle = $this->berujuEntry->resolutionCycles
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->sortByDesc('id')
                ->first();
            
            if ($latestCycle && !$this->latestCycle) {
                $this->berujuAction->cycle_id = $latestCycle->id;
                $this->latestCycle = $latestCycle;
            }
        }
        
        return view("Beruju::livewire.action-form");
    }

    public function mount(BerujuAction $berujuAction = null, Action $action = Action::CREATE, $berujuEntry = null)
    {
        $this->berujuAction = $berujuAction ?? new BerujuAction();
        $this->action = $action;
        $this->berujuEntry = $berujuEntry;
        
        // Get the latest active resolution cycle for this beruju entry
        $latestCycle = null;
        if ($berujuEntry) {
            // Load the resolution cycles with their actions and action types
            $berujuEntry->load([
                'resolutionCycles' => function($query) {
                    $query->where('status', 'active')
                          ->whereNull('deleted_at')
                          ->with(['berujuEntry', 'incharge', 'actions' => function($actionQuery) {
                              $actionQuery->with('actionType');
                          }]);
                }
            ]);
            
            $latestCycle = $berujuEntry->resolutionCycles
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->sortByDesc('id')
                ->first();
        }
        
        if ($latestCycle) {
            $this->berujuAction->cycle_id = $latestCycle->id;
            $this->latestCycle = $latestCycle;
        }
        
        $this->actionTypes = ActionType::whereNull('deleted_at')->pluck('name_eng', 'id');
        
        if ($this->action === Action::CREATE) {
            // Set default values for required fields
            $this->berujuAction->status = 'Pending';
        }
    }

    public function save()
    {
        try {
            $this->validate();
            $dto = ActionAdminDto::fromLiveWireModel($this->berujuAction);
            $service = new ActionAdminService();
        
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('beruju::beruju.action_created_successfully'));
                    $this->dispatch('close-modal');
                    $this->dispatch('action-created');
                    break;
                case Action::UPDATE:
                    $service->update($this->berujuAction, $dto);
                    $this->successFlash(__('beruju::beruju.action_updated_successfully'));
                    $this->dispatch('close-modal');
                    $this->dispatch('action-updated');
                    break;
                default:
                    break;
            }
        } catch (\Exception $e) {
            $this->errorFlash($e->getMessage());
        }
    }

    #[On('edit-action')]
    public function editAction($actionId)
    {
        $this->berujuAction = BerujuAction::findOrFail($actionId);
        $this->action = Action::UPDATE;
        
        // Dispatch event to open the modal
        $this->dispatch('open-action-modal');
    }
    
    #[On('incharge-updated')]
    public function refreshForNewIncharge()
    {
        // Refresh the beruju entry to get the latest data
        if ($this->berujuEntry) {
            $this->berujuEntry->refresh();
            
            // Load the resolution cycles with their actions and action types
            $this->berujuEntry->load([
                'resolutionCycles' => function($query) {
                    $query->where('status', 'active')
                          ->whereNull('deleted_at')
                          ->with(['berujuEntry', 'incharge', 'actions' => function($actionQuery) {
                              $actionQuery->with('actionType');
                          }]);
                }
            ]);
            
            // Get the latest active resolution cycle from the loaded collection
            $latestCycle = $this->berujuEntry->resolutionCycles
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->sortByDesc('id')
                ->first();
            
            if ($latestCycle) {
                $this->berujuAction->cycle_id = $latestCycle->id;
                $this->latestCycle = $latestCycle;
            }
        }
        
        // Force a re-render to update the view
        $this->dispatch('$refresh');
    }
    
    #[On('open-action-modal')]
    public function refreshOnModalOpen()
    {
        // Refresh the beruju entry to get the latest data when modal opens
        if ($this->berujuEntry) {
            $this->berujuEntry->refresh();
            
            // Load the resolution cycles with their actions and action types
            $this->berujuEntry->load([
                'resolutionCycles' => function($query) {
                    $query->where('status', 'active')
                          ->whereNull('deleted_at')
                          ->with(['berujuEntry', 'incharge', 'actions' => function($actionQuery) {
                              $actionQuery->with('actionType');
                          }]);
                }
            ]);
            
            // Get the latest active resolution cycle from the loaded collection
            $latestCycle = $this->berujuEntry->resolutionCycles
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->sortByDesc('id')
                ->first();
            
            if ($latestCycle) {
                $this->berujuAction->cycle_id = $latestCycle->id;
                $this->latestCycle = $latestCycle;
            }
        }
    }

    #[On('reset-form')]
    public function resetAction()
    {
        // Store the cycle_id before resetting
        $cycleId = $this->berujuAction->cycle_id;
        
        $this->reset(['berujuAction', 'action']);
        $this->berujuAction = new BerujuAction();
        $this->action = Action::CREATE;
        
        // Restore the cycle_id
        $this->berujuAction->cycle_id = $cycleId;
        
        // Set default values for required fields
        $this->berujuAction->status = 'Pending';
    }
}
