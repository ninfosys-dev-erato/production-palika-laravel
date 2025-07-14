<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\DisputeAreaAdminDto;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Service\DisputeAreaAdminService;
use Livewire\Attributes\On;

class DisputeAreaForm extends Component
{
    use SessionFlash;

    public ?DisputeArea $disputeArea;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'disputeArea.title' => ['required'],
            'disputeArea.title_en' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.dispute-area.form");
    }

    public function mount(DisputeArea $disputeArea, Action $action)
    {
        $this->disputeArea = $disputeArea;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = DisputeAreaAdminDto::fromLiveWireModel($this->disputeArea);
            $service = new DisputeAreaAdminService();
            switch ($this->action) {
                case Action::CREATE:

                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_area_created_successfully'));
                    // return redirect()->route('admin.ejalas.dispute_areas.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->disputeArea, $dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_area_updated_successfully'));
                    // return redirect()->route('admin.ejalas.dispute_areas.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.dispute_areas.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-dispute-area')]
    public function editDisputeArea(DisputeArea $disputeArea)
    {
        $this->disputeArea = $disputeArea;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['disputeArea', 'action']);
        $this->disputeArea = new DisputeArea();
    }
    #[On('reset-form')]
    public function resetDisputeArea()
    {
        $this->resetForm();
    }
}
