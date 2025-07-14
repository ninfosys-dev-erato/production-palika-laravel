<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\MaterialRateAdminDto;
use Src\Yojana\Models\MaterialRate;
use Src\Yojana\Service\MaterialRateAdminService;

class MaterialRateForm extends Component
{
    use SessionFlash;

    public ?MaterialRate $materialRate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'materialRate.material_id' => ['required'],
    'materialRate.fiscal_year_id' => ['required'],
    'materialRate.is_vat_included' => ['required'],
    'materialRate.is_vat_needed' => ['required'],
    'materialRate.referance_no' => ['required'],
    'materialRate.royalty' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'materialRate.material_id.required' => __('yojana::yojana.material_id_is_required'),
            'materialRate.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'materialRate.is_vat_included.required' => __('yojana::yojana.is_vat_included_is_required'),
            'materialRate.is_vat_needed.required' => __('yojana::yojana.is_vat_needed_is_required'),
            'materialRate.referance_no.required' => __('yojana::yojana.referance_no_is_required'),
            'materialRate.royalty.required' => __('yojana::yojana.royalty_is_required'),
        ];
    }

    public function render(){
        return view("MaterialRates::projects.form");
    }

    public function mount(MaterialRate $materialRate,Action $action)
    {
        $this->materialRate = $materialRate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = MaterialRateAdminDto::fromLiveWireModel($this->materialRate);
        $service = new MaterialRateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Material Rate Created Successfully");
                return redirect()->route('admin.material_rates.index');
                break;
            case Action::UPDATE:
                $service->update($this->materialRate,$dto);
                $this->successFlash("Material Rate Updated Successfully");
                return redirect()->route('admin.material_rates.index');
                break;
            default:
                return redirect()->route('admin.material_rates.index');
                break;
        }
    }
}
