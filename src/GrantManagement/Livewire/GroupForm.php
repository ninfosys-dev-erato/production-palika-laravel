<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\GrantManagement\Controllers\GroupAdminController;
use Src\GrantManagement\DTO\GroupAdminDto;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Models\Group;
use Src\GrantManagement\Service\GroupAdminService;
use Src\Wards\Models\Ward;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class GroupForm extends Component
{
    use SessionFlash;

    public ?Group $group;
    public ?Action $action = Action::CREATE;

    public $districts = [];
    public $provinces = [];
    public $localBodies = [];
    public $wards = [];
    public $farmers = [];
    public array $selectedFarmers = [];
    public $showSelectedFarmerModal = true;
    public function rules(): array
    {
        return [
            'group.name' => ['required'],
            'group.registration_date' => ['required'],
            'group.registered_office' => ['required'],
            'group.monthly_meeting' => ['required'],
            'group.vat_pan' => ['required'],
            'group.province_id' => ['required'],
            'group.district_id' => ['required'],
            'group.local_body_id' => ['required'],
            'group.ward_no' => ['required'],
            'group.village' => ['required'],
            'group.tole' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'group.name.required' => __('grantmanagement::grantmanagement.name_is_required'),
            'group.registration_date.required' => __('grantmanagement::grantmanagement.registration_date_is_required'),
            'group.registered_office.required' => __('grantmanagement::grantmanagement.registered_office_is_required'),
            'group.monthly_meeting.required' => __('grantmanagement::grantmanagement.monthly_meeting_is_required'),
            'group.vat_pan.required' => __('grantmanagement::grantmanagement.vat_pan_is_required'),
            'group.province_id.required' => __('grantmanagement::grantmanagement.province_id_is_required'),
            'group.district_id.required' => __('grantmanagement::grantmanagement.district_id_is_required'),
            'group.local_body_id.required' => __('grantmanagement::grantmanagement.local_body_id_is_required'),
            'group.ward_no.required' => __('grantmanagement::grantmanagement.ward_no_is_required'),
            'group.village.required' => __('grantmanagement::grantmanagement.village_is_required'),
            'group.tole.required' => __('grantmanagement::grantmanagement.tole_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.groups-form");
    }

    public function mount(Group $group, Action $action, bool $showSelectedFarmerModal = true)
    {
        $this->group = $group;
        $this->showSelectedFarmerModal = $showSelectedFarmerModal;
        // $this->farmers = Farmer::whereNull('deleted_at')->get()->pluck('first_name', 'id')->toArray();
        $this->farmers = Farmer::whereNull('deleted_by')
            ->with('user')
            ->get()
            ->mapWithKeys(function ($farmer) {
                return [$farmer->id => optional($farmer->user)->name];
            })
            ->toArray();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();

        $this->action = $action;

        if ($action == Action::UPDATE) {
            $this->selectedFarmers = $group->farmers->pluck('id')->toArray();
        }
    }



    public function getDistricts()
    {
        $this->districts = getDistricts($this->group['province_id'])->pluck('title', 'id')->toArray();

        $this->localBodies = [];
        $this->wards = [];
    }

    public function getLocalBodies()
    {
        $this->localBodies = getLocalBodies($this->group['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards()
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->group['local_body_id'])->wards);
    }


    public function save()
    {
        $this->validate();
        $dto = GroupAdminDto::fromLiveWireModel($this->group);
        $service = new GroupAdminService();
        DB::beginTransaction();

        try {

            switch ($this->action) {
                case Action::CREATE:
                    $group = $service->store($dto);
                    $group->farmers()->sync($this->selectedFarmers);
                    DB::commit();

                    // if (!empty($this->selectedFarmers)) {
                    if (!$this->showSelectedFarmerModal) {
                        $this->successToast(__('grantmanagement::grantmanagement.group_created_successfully'));
                        $this->dispatch('group-created');
                        $this->dispatch('close-modal');
                        $this->resetForm();
                    } else {
                        $this->successFlash(__('grantmanagement::grantmanagement.group_created_successfully'));
                        return redirect()->route('admin.groups.index');
                    }
                    break;
                case Action::UPDATE:
                    $service->update($this->group, $dto);

                    if (!empty($this->selectedFarmers)) {
                        $this->group->farmers()->sync($this->selectedFarmers);
                    }
                    DB::commit();

                    $this->successFlash(__('grantmanagement::grantmanagement.group_updated_successfully'));
                    return redirect()->route('admin.groups.index');
                    break;
                default:
                    return redirect()->route('admin.groups.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('grantmanagement::grantmanagement.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    #[On('edit-group')]
    public function editGroup(Group $group)
    {
        $this->group = $group;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['group', 'action']);
        $this->group = new Group();
    }
    #[On('reset-form')]
    public function resetGroup()
    {
        $this->resetForm();
    }
}
