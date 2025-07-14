<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\DisputeMatterAdminDto;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Models\DisputeMatter;
use Src\Ejalas\Service\DisputeMatterAdminService;
use Livewire\Attributes\On;

class DisputeMatterForm extends Component
{
    use SessionFlash;

    public ?DisputeMatter $disputeMatter;
    public ?Action $action = Action::CREATE;
    public $disputeAreas;

    public function rules(): array
    {
        return [
            'disputeMatter.title' => ['required'],
            'disputeMatter.dispute_area_id' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.dispute-matter.form");
    }

    public function mount(DisputeMatter $disputeMatter, Action $action)
    {
        $this->disputeMatter = $disputeMatter;
        $this->action = $action;
        $this->disputeAreas = DisputeArea::whereNull('deleted_at')->pluck('title_en', 'id');
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = DisputeMatterAdminDto::fromLiveWireModel($this->disputeMatter);
            $service = new DisputeMatterAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_matter_created_successfully'));
                    // return redirect()->route('admin.ejalas.dispute_matters.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->disputeMatter, $dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_matter_updated_successfully'));
                    // return redirect()->route('admin.ejalas.dispute_matters.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.dispute_matters.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-dispute-matter')]
    public function editDisputeArea(DisputeMatter $disputeMatter)
    {
        $this->disputeMatter = $disputeMatter;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['disputeMatter', 'action']);
        $this->disputeMatter = new DisputeMatter();
    }
    #[On('reset-form')]
    public function resetDisputeArea()
    {
        $this->resetForm();
    }
}
