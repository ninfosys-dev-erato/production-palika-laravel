<?php

namespace Src\Wards\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Wards\Controllers\WardAdminController;
use Src\Wards\DTO\WardAdminDto;
use Src\Wards\Models\Ward;
use Src\Wards\Service\WardAdminService;

class WardForm extends Component
{
    use SessionFlash;

    public ?Ward $ward;
    public ?Action $action;

    public function rules(): array
    {
        $rules = [
            'ward.id' => [
                'required',
                Rule::unique('tbl_wards', 'id')->ignore($this->ward['id']),
            ],
            'ward.local_body_id' => ['required'],
            'ward.phone' => ['required'],
            'ward.email' => ['required'],
            'ward.address_en' => ['required'],
            'ward.address_ne' => ['required'],
            'ward.ward_name_en' => ['required'],
            'ward.ward_name_ne' => ['required'],
        ];   
        return $rules;
    }
    public function messages(): array
    {
        return [
            'ward.phone.required' => __('wards::wards.phone_is_required'),
            'ward.email.required' => __('wards::wards.email_is_required'),
            'ward.address_en.required' => __('wards::wards.address_en_is_required'),
            'ward.address_ne.required' => __('wards::wards.address_ne_is_required'),
            'ward.ward_name_en.required' => __('wards::wards.ward_name_en_is_required'),
            'ward.ward_name_ne.required' => __('wards::wards.ward_name_ne_is_required'),
        ];
    }

    public function render()
    {
        return view("Wards::livewire.form");
    }

    public function mount(Ward $ward, Action $action)
    {
        $this->ward = $ward;
        $this->action = $action;
        $this->ward->local_body_id = key(getSettingWithKey('palika-local-body'));
    }

    public function save()
    {
        
        $this->validate();
        try{
            $dto = WardAdminDto::fromLiveWireModel($this->ward);
            $service = new WardAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Ward Created Successfully");
                    return redirect()->route('admin.wards.index');
                case Action::UPDATE:
                    $service->update($this->ward, $dto);
                    $this->successFlash("Ward Updated Successfully");
                    return redirect()->route('admin.wards.index');
                default:
                    return redirect()->route('admin.wards.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
