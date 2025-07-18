<?php

namespace Src\Districts\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Districts\Controllers\DistrictAdminController;
use Src\Districts\DTO\DistrictAdminDto;
use Src\Districts\Models\District;
use Src\Districts\Service\DistrictAdminService;

class DistrictForm extends Component
{
    use SessionFlash;

    public ?District $district;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'district.province_id' => ['required'],
    'district.title' => ['required'],
    'district.title_en' => ['required'],
];
    }

    public function messages(): array
    {
        return [
            'district.province_id.required' => __('The province ID is required.'),
            'district.title.required' => __('The title is required.'),
            'district.title_en.required' => __('The English title is required.'),
        ];
    }

    public function render(){
        return view("Districts::livewire.form");
    }

    public function mount(District $district,Action $action)
    {
        $this->district = $district;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = DistrictAdminDto::fromLiveWireModel($this->district);
        $service = new DistrictAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("District Created Successfully");
                return redirect()->route('admin.districts.index');
                break;
            case Action::UPDATE:
                $service->update($this->district,$dto);
                $this->successFlash("District Updated Successfully");
                return redirect()->route('admin.districts.index');
                break;
            default:
                return redirect()->route('admin.districts.index');
                break;
        }
    }
}
