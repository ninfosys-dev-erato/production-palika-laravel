<?php

namespace Src\Committees\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Committees\Controllers\CommitteeAdminController;
use Src\Committees\DTO\CommitteeAdminDto;
use Src\Committees\Models\Committee;
use Src\Committees\Service\CommitteeAdminService;

class CommitteeForm extends Component
{
    use SessionFlash;

    public ?Committee $committee;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'committee.committee_type_id' => ['required'],
    'committee.committee_name' => ['required'],
];
    }

    public function messages(): array
{
    return [
        'committee.committee_type_id.required' => __('The committee type ID is required.'),
        'committee.committee_name.required' => __('The committee name is required.'),
    ];
}
    public function render(){
        return view("Committees::livewire.form");
    }

    public function mount(Committee $committee,Action $action)
    {
        $this->committee = $committee;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = CommitteeAdminDto::fromLiveWireModel($this->committee);
            $service = new CommitteeAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Committee Created Successfully"));
                    return redirect()->route('admin.committees.index');
                case Action::UPDATE:
                    $service->update($this->committee,$dto);
                    $this->successFlash(__("Committee Updated Successfully"));
                    return redirect()->route('admin.committees.index');
                default:
                    return redirect()->route('admin.committees.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
