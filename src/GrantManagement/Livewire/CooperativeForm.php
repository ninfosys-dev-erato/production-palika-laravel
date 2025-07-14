<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\GrantManagement\Controllers\CooperativeAdminController;
use Src\GrantManagement\DTO\CooperativeAdminDto;
use Src\GrantManagement\Models\Affiliation;
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Models\CooperativeType;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Models\Group;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Service\CooperativeAdminService;
use Src\Provinces\Models\Province;
use Src\Wards\Models\Ward;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class CooperativeForm extends Component
{
    use SessionFlash;

    public ?Cooperative $cooperative;
    public ?Action $action = Action::CREATE;

    public $cooperative_types = [];
    public $affiliations = [];
    public $provinces = [];
    public $localBodies = [];
    public $wards = [];
    public $districts = [];
    public $farmers = [];
    public $groups = [];
    public $enterprises = [];
    public $cooperatives = [];
    public array $selectedFarmers = [];
    public array $selectedGroups = [];
    public array $selectedEnterprises = [];
    public array $selectedCooperatives = [];

    public $showSelectedFarmerModal = true;
    public $showModal = false;

    public function rules(): array
    {
        return [
            'cooperative.name' => ['required'],
            'cooperative.cooperative_type_id' => ['required'],
            'cooperative.registration_no' => ['required'],
            'cooperative.registration_date' => ['required'],
            'cooperative.vat_pan' => ['required'],
            'cooperative.objective' => ['required'],
            'cooperative.province_id' => ['required'],
            'cooperative.affiliation_id' => ['required'],
            'cooperative.district_id' => ['required'],
            'cooperative.local_body_id' => ['required'],
            'cooperative.ward_no' => ['required'],
            'cooperative.village' => ['required'],
            'cooperative.tole' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'cooperative.name.required' => __('grantmanagement::grantmanagement.name_is_required'),
            'cooperative.cooperative_type_id.required' => __('grantmanagement::grantmanagement.cooperative_type_id_is_required'),
            'cooperative.registration_no.required' => __('grantmanagement::grantmanagement.registration_no_is_required'),
            'cooperative.registration_date.required' => __('grantmanagement::grantmanagement.registration_date_is_required'),
            'cooperative.vat_pan.required' => __('grantmanagement::grantmanagement.vat_pan_is_required'),
            'cooperative.affiliation_id.required' => __('grantmanagement::grantmanagement.affiliation_is_required'),
            'cooperative.objective.required' => __('grantmanagement::grantmanagement.objective_is_required'),
            'cooperative.province_id.required' => __('grantmanagement::grantmanagement.province_id_is_required'),
            'cooperative.district_id.required' => __('grantmanagement::grantmanagement.district_id_is_required'),
            'cooperative.local_body_id.required' => __('grantmanagement::grantmanagement.local_body_id_is_required'),
            'cooperative.ward_no.required' => __('grantmanagement::grantmanagement.ward_no_is_required'),
            'cooperative.village.required' => __('grantmanagement::grantmanagement.village_is_required'),
            'cooperative.tole.required' => __('grantmanagement::grantmanagement.tole_is_required'),
        ];
    }

    public function mount(Cooperative $cooperative, Action $action, bool $showSelectedFarmerModal = true, bool $showModal = false)
    {
        $this->cooperative = $cooperative->load(['farmers']);
        $this->action = $action;
        $this->showSelectedFarmerModal = $showSelectedFarmerModal;
        $this->showModal = $showModal;

        $this->cooperative_types = CooperativeType::whereNull('deleted_by')->pluck('title', 'id')->toArray();
        // $this->farmers = Farmer::whereNull('deleted_by')->pluck('first_name', 'id')->toArray();

        $this->farmers = Farmer::whereNull('deleted_by')
            ->with('user')
            ->get()
            ->mapWithKeys(function ($farmer) {
                return [$farmer->id => optional($farmer->user)->name];
            })
            ->toArray();
        $this->affiliations = Affiliation::whereNull('deleted_by')->pluck('title', 'id')->toArray();
        // $this->groups = Group::whereNull('deleted_by')->pluck('name', 'id')->toArray();
        // $this->enterprises = Enterprise::whereNull('deleted_by')->pluck('name', 'id')->toArray();
        $this->cooperatives = Cooperative::whereNull('deleted_by')->pluck('name', 'id')->toArray();

        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        if ($action == Action::UPDATE) {
            $this->selectedFarmers = $cooperative->farmers->pluck('id')->toArray();
        }
    }

    public function openFarmerModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function getDistricts(): void
    {
        $this->districts = getDistricts($this->cooperative['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }


    public function getLocalBodies(): void
    {
        $this->localBodies = getLocalBodies($this->cooperative['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->cooperative['local_body_id'])->wards);
    }

    public function save()
    {
        $this->validate();

        $dto = CooperativeAdminDto::fromLiveWireModel($this->cooperative);
        $service = new CooperativeAdminService();

        DB::beginTransaction();
        try {
            if ($this->action === Action::CREATE) {
                $cooperative = $service->store($dto);
                $cooperative->farmers()->sync($this->selectedFarmers);
                // $cooperative->groups()->sync($this->selectedGroups);
                // $cooperative->enterprises()->sync($this->selectedEnterprises);
                // $cooperative->relatedCooperatives()->sync($this->selectedCooperatives);

                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_created_successfully'));
                if (!$this->showSelectedFarmerModal) {
                    $this->dispatch('close-modal');
                    $this->resetForm();
                } else {
                    return redirect()->route('admin.cooperative.index');
                }
            } elseif ($this->action === Action::UPDATE) {
                $service->update($this->cooperative, $dto);
                if (!empty($this->selectedFarmers)) {
                    $this->cooperative->farmers()->sync($this->selectedFarmers);
                }

                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.cooperative_updated_successfully'));
                return redirect()->route('admin.cooperative.index');
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('grantmanagement::grantmanagement.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    public function render()
    {
        return view("GrantManagement::livewire.cooperatives-form");
    }

    private function resetForm()
    {
        $this->reset(['cooperative', 'action']);
        $this->cooperative = new Cooperative();
    }
    #[On('reset-form')]
    public function resetCooperative()
    {
        $this->resetForm();
    }
}
