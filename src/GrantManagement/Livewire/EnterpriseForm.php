<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\EnterpriseAdminController;
use Src\GrantManagement\DTO\EnterpriseAdminDto;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Service\EnterpriseAdminService;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\GrantManagement\Models\EnterpriseType;
use Src\GrantManagement\Models\Farmer;
use Src\Wards\Models\Ward;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class EnterpriseForm extends Component
{
    use SessionFlash;

    public ?Enterprise $enterprise;
    public ?Action $action = Action::CREATE;
    public $enterpriseses = [];
    public $provinces = [];
    public $localBodies = [];
    public $wards = [];
    public $districts = [];
    public $farmers = [];
    public array $selectedFarmers = [];
    public $showSelectedFarmerModal = true;

    public function rules(): array
    {
        return [
            'enterprise.enterprise_type_id' => ['required'],
            'enterprise.name' => ['required'],
            'enterprise.vat_pan' => ['required'],
            'enterprise.province_id' => ['required'],
            'enterprise.district_id' => ['required'],
            'enterprise.local_body_id' => ['required'],
            'enterprise.ward_no' => ['required'],
            'enterprise.village' => ['required'],
            'enterprise.tole' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'enterprise.enterprise_type_id.required' => __('grantmanagement::grantmanagement.enterprise_type_id_is_required'),
            'enterprise.name.required' => __('grantmanagement::grantmanagement.name_is_required'),
            'enterprise.vat_pan.required' => __('grantmanagement::grantmanagement.vat_pan_is_required'),
            'enterprise.province_id.required' => __('grantmanagement::grantmanagement.province_id_is_required'),
            'enterprise.district_id.required' => __('grantmanagement::grantmanagement.district_id_is_required'),
            'enterprise.local_body_id.required' => __('grantmanagement::grantmanagement.local_body_id_is_required'),
            'enterprise.ward_no.required' => __('grantmanagement::grantmanagement.ward_no_is_required'),
            'enterprise.village.required' => __('grantmanagement::grantmanagement.village_is_required'),
            'enterprise.tole.required' => __('grantmanagement::grantmanagement.tole_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.enterprises-form");
    }

    public function mount(Enterprise $enterprise, Action $action, bool $showSelectedFarmerModal = true)
    {
        $this->enterprise = $enterprise;
        $this->showSelectedFarmerModal = $showSelectedFarmerModal;

        $this->enterpriseses = EnterpriseType::whereNull('deleted_by')->get()->pluck('title', 'id')->toArray();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        // $this->farmers = Farmer::whereNull('deleted_by')->get()->pluck('first_name', 'id')->toArray();
        $this->farmers = Farmer::whereNull('deleted_by')
            ->with('user')
            ->get()
            ->mapWithKeys(function ($farmer) {
                return [$farmer->id => optional($farmer->user)->name];
            })
            ->toArray();

        $this->action = $action;

        if ($action == Action::UPDATE) {
            $this->selectedFarmers = $enterprise->farmers->pluck('id')->toArray();
        }
    }

    public function getDistricts(): void
    {
        $this->districts = getDistricts($this->enterprise['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }

    public function getLocalBodies(): void
    {
        $this->localBodies = getLocalBodies($this->enterprise['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->enterprise['local_body_id'])->wards);
    }

    public function save()
    {
        $this->validate();
        $dto = EnterpriseAdminDto::fromLiveWireModel($this->enterprise);
        $service = new EnterpriseAdminService();
        DB::beginTransaction();

        switch ($this->action) {
            case Action::CREATE:
                $enterprise = $service->store($dto);
                $enterprise->farmers()->sync($this->selectedFarmers);
                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_created_successfully'));
                if (!$this->showSelectedFarmerModal) {
                    $this->dispatch('close-modal');
                    $this->resetForm();
                } else {
                    return redirect()->route('admin.enterprises.index');
                }
                break;
            case Action::UPDATE:
                $service->update($this->enterprise, $dto);

                if (!empty($this->selectedFarmers)) {
                    $this->enterprise->farmers()->sync($this->selectedFarmers);
                }
                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_updated_successfully'));
                return redirect()->route('admin.enterprises.index');
                break;
            default:
                return redirect()->route('admin.enterprises.index');
                break;
        }
    }


    private function resetForm()
    {
        $this->reset(['enterprise', 'action']);
        $this->enterprise = new Enterprise();
    }
    #[On('reset-form')]
    public function resetEnterprise()
    {
        $this->resetForm();
    }
}
