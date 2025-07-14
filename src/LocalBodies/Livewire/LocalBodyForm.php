<?php

namespace Src\LocalBodies\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\LocalBodies\Controllers\LocalBodyAdminController;
use Src\LocalBodies\DTO\LocalBodyAdminDto;
use Src\LocalBodies\Models\LocalBody;
use Src\LocalBodies\Service\LocalBodyAdminService;

class LocalBodyForm extends Component
{
    use SessionFlash;

    public ?LocalBody $localBody;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'localBody.district_id' => ['required'],
    'localBody.title' => ['required'],
    'localBody.title_en' => ['required'],
    'localBody.wards' => ['required'],
];
    }

    public function render(){
        return view("LocalBodies::livewire.form");
    }

    public function mount(LocalBody $localBody,Action $action)
    {
        $this->localBody = $localBody;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = LocalBodyAdminDto::fromLiveWireModel($this->localBody);
            $service = new LocalBodyAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Local Body Created Successfully");
                    return redirect()->route('admin.local-bodies.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->localBody,$dto);
                    $this->successFlash("Local Body Updated Successfully");
                    return redirect()->route('admin.local-bodies.index');
                    break;
                default:
                    return redirect()->route('admin.local-bodies.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
