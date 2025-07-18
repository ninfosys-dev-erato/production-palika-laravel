<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\LabourAdminDto;
use Src\Yojana\Models\Labour;
use Src\Yojana\Service\LabourAdminService;

class LabourForm extends Component
{
    use SessionFlash;

    public ?Labour $labour;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'labour.title' => ['required'],
    'labour.unit_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'labour.title.required' => __('yojana::yojana.title_is_required'),
            'labour.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
        ];
    }

    public function render(){
        return view("Labours::livewire.form");
    }

    public function mount(Labour $labour,Action $action)
    {
        $this->labour = $labour;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = LabourAdminDto::fromLiveWireModel($this->labour);
        $service = new LabourAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Labour Created Successfully");
                return redirect()->route('admin.labours.index');
                break;
            case Action::UPDATE:
                $service->update($this->labour,$dto);
                $this->successFlash("Labour Updated Successfully");
                return redirect()->route('admin.labours.index');
                break;
            default:
                return redirect()->route('admin.labours.index');
                break;
        }
    }
}
