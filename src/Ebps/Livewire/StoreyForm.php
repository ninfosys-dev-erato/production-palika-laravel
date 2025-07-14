<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Storeys\Controllers\StoreyAdminController;
use Src\Ebps\DTO\StoreyAdminDto;
use Src\Ebps\Models\Storey;
use Src\Ebps\Service\StoreyAdminService;
use Livewire\Attributes\On;

class StoreyForm extends Component
{
    use SessionFlash;

    public ?Storey $storey;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'storey.title' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ebps::livewire.storey.storey-form");
    }

    public function mount(Storey $storey, Action $action)
    {
        $this->storey = $storey;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = StoreyAdminDto::fromLiveWireModel($this->storey);
            $service = new StoreyAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.storey_created_successfully'));
                    // return redirect()->route('admin.ebps.storeys.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->storey, $dto);
                    $this->successFlash(__('ebps::ebps.storey_updated_successfully'));
                    // return redirect()->route('admin.ebps.storeys.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.storeys.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }


    #[On('edit-storey')]
    public function editStorey(Storey $storey)
    {
        $this->storey = $storey;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['storey', 'action']);
        $this->storey = new Storey();
    }
    #[On('reset-form')]
    public function resetStorey()
    {
        $this->resetForm();
    }
}
