<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\MediatorAdminDto;
use Src\Ejalas\Models\Mediator;
use Src\Ejalas\Service\MediatorAdminService;
use Src\FiscalYears\Models\FiscalYear;
use Src\Wards\Models\Ward;
use Livewire\Attributes\On;

class MediatorForm extends Component
{
    use SessionFlash;

    public ?Mediator $mediator;
    public ?Action $action = Action::CREATE;
    public $fiscalYears;
    public $wards;


    public function rules(): array
    {
        return [
            'mediator.listed_no' => ['nullable'],
            'mediator.mediator_name' => ['required'],
            'mediator.mediator_address' => ['required'],
            'mediator.ward_id' => ['nullable'],
            'mediator.training_detail' => ['nullable'],
            'mediator.mediator_phone_no' => ['required'],
            'mediator.mediator_email' => ['nullable'],
            'mediator.municipal_approval_date' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.mediator.form");
    }

    public function mount(Mediator $mediator, Action $action)
    {
        $this->mediator = $mediator;
        $this->action = $action;
        $this->fiscalYears = FiscalYear::whereNull("deleted_at")->get();
        $this->wards = Ward::whereNull("deleted_at")->pluck('ward_name_en', 'id');
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = MediatorAdminDto::fromLiveWireModel($this->mediator);
            $service = new MediatorAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.mediator_created_successfully'));
                    // return redirect()->route('admin.ejalas.mediators.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->mediator, $dto);
                    $this->successFlash(__('ejalas::ejalas.mediator_updated_successfully'));
                    // return redirect()->route('admin.ejalas.mediators.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.mediators.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-mediator')]
    public function editMediator(Mediator $mediator)
    {
        $this->mediator = $mediator;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['mediator', 'action']);
        $this->mediator = new Mediator();
    }
    #[On('reset-form')]
    public function resetMediator()
    {
        $this->resetForm();
    }
}
