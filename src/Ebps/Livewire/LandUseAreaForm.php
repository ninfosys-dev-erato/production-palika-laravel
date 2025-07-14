<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\LandUseAreas\Controllers\LandUseAreaAdminController;
use Src\Ebps\DTO\LandUseAreaAdminDto;
use Src\Ebps\Models\LandUseArea;
use Src\Ebps\Service\LandUseAreaAdminService;
use Livewire\Attributes\On;

class LandUseAreaForm extends Component
{
    use SessionFlash;

    public ?LandUseArea $landUseArea;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'landUseArea.title' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ebps::livewire.land-use-area.land-use-area-form");
    }

    public function mount(LandUseArea $landUseArea, Action $action)
    {
        $this->landUseArea = $landUseArea;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = LandUseAreaAdminDto::fromLiveWireModel($this->landUseArea);
            $service = new LandUseAreaAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.land_use_area_created_successfully'));
                    // return redirect()->route('admin.ebps.land_use_areas.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();

                    break;
                case Action::UPDATE:
                    $service->update($this->landUseArea, $dto);
                    $this->successFlash(__('ebps::ebps.land_use_area_updated_successfully'));
                    // return redirect()->route('admin.ebps.land_use_areas.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.land_use_areas.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('edit-land-use-area')]
    public function editLandUseArea(LandUseArea $landUseArea)
    {
        $this->landUseArea = $landUseArea;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['landUseArea', 'action']);
        $this->landUseArea = new LandUseArea();
    }
    #[On('reset-form')]
    public function resetLandUseArea()
    {
        $this->resetForm();
    }
}
