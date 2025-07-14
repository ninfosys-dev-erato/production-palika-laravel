<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\ConstructionTypes\Controllers\ConstructionTypeAdminController;
use Src\Ebps\DTO\ConstructionTypeAdminDto;
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Service\ConstructionTypeAdminService;
use Livewire\Attributes\On;

class ConstructionTypeForm extends Component
{
    use SessionFlash;

    public ?ConstructionType $constructionType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'constructionType.title' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ebps::livewire.construction-type.construction-type-form");
    }

    public function mount(ConstructionType $constructionType, Action $action)
    {
        $this->constructionType = $constructionType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = ConstructionTypeAdminDto::fromLiveWireModel($this->constructionType);
            $service = new ConstructionTypeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.construction_type_created_successfully'));
                    // return redirect()->route('admin.ebps.construction_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->constructionType, $dto);
                    $this->successFlash(__('ebps::ebps.construction_type_updated_successfully'));
                    // return redirect()->route('admin.ebps.construction_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.construction_types.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }


    #[On('edit-construction-type')]
    public function editConstructionType(ConstructionType $constructionType)
    {
        $this->constructionType = $constructionType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['constructionType', 'action']);
        $this->constructionType = new ConstructionType();
    }
    #[On('reset-form')]
    public function resetConstructionType()
    {
        $this->resetForm();
    }
}
