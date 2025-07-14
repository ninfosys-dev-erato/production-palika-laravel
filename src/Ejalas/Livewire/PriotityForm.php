<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\PriotityAdminDto;
use Src\Ejalas\Models\Priotity;
use Src\Ejalas\Service\PriotityAdminService;
use Livewire\Attributes\On;

class PriotityForm extends Component
{
    use SessionFlash;

    public ?Priotity $priotity;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'priotity.name' => ['required'],
            'priotity.position' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.priotity.form");
    }

    public function mount(Priotity $priotity, Action $action)
    {
        $this->priotity = $priotity;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = PriotityAdminDto::fromLiveWireModel($this->priotity);
            $service = new PriotityAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.priotity_created_successfully'));
                    // return redirect()->route('admin.ejalas.priotities.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->priotity, $dto);
                    $this->successFlash(__('ejalas::ejalas.priotity_updated_successfully'));
                    // return redirect()->route('admin.ejalas.priotities.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.priotities.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-priotity')]
    public function editPriotity(Priotity $priotity)
    {
        $this->priotity = $priotity;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['priotity', 'action']);
        $this->priotity = new Priotity();
    }
    #[On('reset-form')]
    public function resetPriotity()
    {
        $this->resetForm();
    }
}
