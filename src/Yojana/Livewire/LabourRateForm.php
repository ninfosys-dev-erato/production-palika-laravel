<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\LabourRateAdminDto;
use Src\Yojana\Models\LabourRate;
use Src\Yojana\Service\LabourRateAdminService;

class LabourRateForm extends Component
{
    use SessionFlash;

    public ?LabourRate $labourRate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'labourRate.fiscal_year_id' => ['required'],
    'labourRate.labour_id' => ['required'],
    'labourRate.rate' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'labourRate.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'labourRate.labour_id.required' => __('yojana::yojana.labour_id_is_required'),
            'labourRate.rate.required' => __('yojana::yojana.rate_is_required'),
        ];
    }

    public function render(){
        return view("LabourRates::projects.form");
    }

    public function mount(LabourRate $labourRate,Action $action)
    {
        $this->labourRate = $labourRate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = LabourRateAdminDto::fromLiveWireModel($this->labourRate);
        $service = new LabourRateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Labour Rate Created Successfully");
                return redirect()->route('admin.labour_rates.index');
                break;
            case Action::UPDATE:
                $service->update($this->labourRate,$dto);
                $this->successFlash("Labour Rate Updated Successfully");
                return redirect()->route('admin.labour_rates.index');
                break;
            default:
                return redirect()->route('admin.labour_rates.index');
                break;
        }
    }
}
