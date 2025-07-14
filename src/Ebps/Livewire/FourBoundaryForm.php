<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FourBoundaries\Controllers\FourBoundaryAdminController;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Service\FourBoundaryAdminService;

class FourBoundaryForm extends Component
{
    use SessionFlash;

    public ?FourBoundary $fourBoundary;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fourBoundary.land_detail_id' => ['required'],
    'fourBoundary.title' => ['required'],
    'fourBoundary.direction' => ['required'],
    'fourBoundary.distance' => ['required'],
    'fourBoundary.lot_no' => ['required'],
];
    }

    public function render(){
        return view("Ebps::livewire.four-boundary.four-boundary-form");
    }

    public function mount(FourBoundary $fourBoundary,Action $action)
    {
        $this->fourBoundary = $fourBoundary;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = FourBoundaryAdminDto::fromLiveWireModel($this->fourBoundary);
            $service = new FourBoundaryAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.four_boundary_created_successfully'));
                    return redirect()->route('admin.four_boundaries.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->fourBoundary,$dto);
                    $this->successFlash(__('ebps::ebps.four_boundary_updated_successfully'));
                    return redirect()->route('admin.four_boundaries.index');
                    break;
                default:
                    return redirect()->route('admin.four_boundaries.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
