<?php

namespace Src\Committees\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Committees\DTO\CommitteeTypeAdminDto;
use Src\Committees\Models\CommitteeType;
use Src\Committees\Service\CommitteeTypeAdminService;

class CommitteeTypeForm extends Component
{
    use SessionFlash;

    public ?CommitteeType $committeeType;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'committeeType.name' => ['required', 'string', 'max:255'],
            'committeeType.committee_no' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'committeeType.name.required' => __('The committee name is required.'),
            'committeeType.name.string' => __('The committee name must be a string.'),
            'committeeType.name.max' => __('The committee name must not exceed 255 characters.'),
            'committeeType.committee_no.required' => __('The committee number is required.'),
            'committeeType.committee_no.integer' => __('The committee number must be an integer.'),
            'committeeType.committee_no.min' => __('The committee number must be at least 1.'),
        ];
    }

    public function render(){
        return view("Committees::livewire.committee-type.form");
    }

    public function mount(CommitteeType $committeeType,Action $action)
    {
        $this->committeeType = $committeeType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = CommitteeTypeAdminDto::fromLiveWireModel($this->committeeType);
            $service = new CommitteeTypeAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Committee Type Created Successfully"));
                    return redirect()->route('admin.committee-types.index');
                case Action::UPDATE:
                    $service->update($this->committeeType,$dto);
                    $this->successFlash(__("Committee Type Updated Successfully"));
                    return redirect()->route('admin.committee-types.index');
                default:
                    return redirect()->route('admin.committee-types.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
