<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\ReconciliationCenterAdminDto;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\ReconciliationCenterAdminService;
use Livewire\Attributes\On;

class ReconciliationCenterForm extends Component
{
    use SessionFlash;

    public ?ReconciliationCenter $reconciliationCenter;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'reconciliationCenter.reconciliation_center_title' => ['required'],
            'reconciliationCenter.surname' => ['required'],
            'reconciliationCenter.title' => ['nullable'],
            'reconciliationCenter.subtile' => ['nullable'],
            'reconciliationCenter.ward_id' => ['required'],
            'reconciliationCenter.established_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.reconciliation-center.form");
    }

    public function mount(ReconciliationCenter $reconciliationCenter, Action $action)
    {
        $this->reconciliationCenter = $reconciliationCenter;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = ReconciliationCenterAdminDto::fromLiveWireModel($this->reconciliationCenter);
            $service = new ReconciliationCenterAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.reconciliation_center_created_successfully'));
                    // return redirect()->route('admin.ejalas.reconciliation_centers.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->reconciliationCenter, $dto);
                    $this->successFlash(__('ejalas::ejalas.reconciliation_center_updated_successfully'));
                    // return redirect()->route('admin.ejalas.reconciliation_centers.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.reconciliation_centers.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


    #[On('edit-reconciliation-center')]
    public function editReconciliationCenter(ReconciliationCenter $reconciliationCenter)
    {
        $this->reconciliationCenter = $reconciliationCenter;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['reconciliationCenter', 'action']);
        $this->reconciliationCenter = new ReconciliationCenter();
    }
    #[On('reset-form')]
    public function resetDReconciliationCenter()
    {
        $this->resetForm();
    }
}
