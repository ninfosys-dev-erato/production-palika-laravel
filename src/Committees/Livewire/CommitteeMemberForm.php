<?php

namespace Src\Committees\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Committees\DTO\CommitteeMemberAdminDto;
use Src\Committees\Models\CommitteeMember;
use Src\Committees\Service\CommitteeMemberAdminService;
use Src\Employees\Models\Employee;
use Livewire\Attributes\On;

class CommitteeMemberForm extends Component
{
    use SessionFlash, HelperDate;

    public ?CommitteeMember $committeeMember;
    public ?Action $action;
    public array $wards = [];
    public array $districts = [];
    public array $localBodies = [];
    public ?string $employeePhone = null; // For search input
    public bool $isModalForm = false;

    public function searchEmployee(): void
    {
        $employee = Employee::where('phone',  $this->employeePhone )->first();

        if ($employee) {
            $this->committeeMember->name = $employee->name;
            $this->committeeMember->email = $employee->email;
            $this->committeeMember->phone = $employee->phone;
        }
    }
    public function rules(): array
    {
        return [
            'committeeMember.committee_id' => ['required'],
            'committeeMember.name' => ['required', 'string'],
            'committeeMember.designation' => ['nullable', 'string'],
            'committeeMember.phone' => ['required', 'string'],
            'committeeMember.photo' => ['nullable', 'string'],
            'committeeMember.email' => ['nullable', 'email'],
            'committeeMember.province_id' => ['required', 'integer', 'exists:add_provinces,id,deleted_at,NULL'],
            'committeeMember.district_id' => ['required', 'integer', 'exists:add_districts,id,deleted_at,NULL'],
            'committeeMember.local_body_id' => ['required', 'integer', 'exists:add_local_bodies,id,deleted_at,NULL'],
            'committeeMember.ward_no' => ['nullable', 'integer'],
            'committeeMember.tole' => ['nullable', 'string'],
            'committeeMember.position' => ['required', 'integer'],
        ];
    }
    public function messages(): array
    {
        return [
            'committeeMember.committee_id.required' => __('The committee ID is required.'),
            'committeeMember.name.required' => __('The name field is required.'),
            'committeeMember.name.string' => __('The name must be a string.'),
            'committeeMember.designation.string' => __('The designation must be a string.'),
            'committeeMember.phone.string' => __('The phone must be a string.'),
            'committeeMember.phone.required' => __('The phone field is required.'),
            'committeeMember.photo.string' => __('The photo must be a string.'),
            'committeeMember.email.email' => __('The email must be a valid email address.'),
            'committeeMember.province_id.required' => __('The province is required.'),
            'committeeMember.province_id.integer' => __('The province must be an integer.'),
            'committeeMember.province_id.exists' => __('The selected province is invalid.'),
            'committeeMember.district_id.required' => __('The district is required.'),
            'committeeMember.district_id.integer' => __('The district must be an integer.'),
            'committeeMember.district_id.exists' => __('The selected district is invalid.'),
            'committeeMember.local_body_id.required' => __('The local body is required.'),
            'committeeMember.local_body_id.integer' => __('The local body must be an integer.'),
            'committeeMember.local_body_id.exists' => __('The selected local body is invalid.'),
            'committeeMember.ward_no.integer' => __('The ward number must be an integer.'),
            'committeeMember.tole.string' => __('The tole must be a string.'),
            'committeeMember.position.required' => __('The position is required.'),
            'committeeMember.position.integer' => __('The position must be an integer.'),
        ];
    }

    public function loadDistricts()
    {
        $this->districts = getDistricts($this->committeeMember['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }

    public function loadLocalBodies(): void
    {
        $this->localBodies = getLocalBodies(district_ids: $this->committeeMember['district_id'])->pluck('title', 'id')->toArray();

        $this->wards = [];
    }

    public function loadWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->committeeMember['local_body_id'])->wards);
    }

    public function render()
    {
        return view("Committees::livewire.committee-member.form");
    }

    public function mount(CommitteeMember $committeeMember, Action $action, bool $isModalForm=false)
    {
        $this->committeeMember = $committeeMember;
        $this->isModalForm = $isModalForm;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $this->committeeMember->phone = $this->convertNepaliToEnglish($this->committeeMember->phone);
            $dto = CommitteeMemberAdminDto::fromLiveWireModel($this->committeeMember);
            $service = new CommitteeMemberAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Committee Member Created Successfully"));
                    if (!$this->isModalForm) {
                        return redirect()->route('admin.committee-members.index');
                    }
                case Action::UPDATE:
                    $service->update($this->committeeMember, $dto);
                    $this->successFlash(__("Committee Member Updated Successfully"));
                    return redirect()->route('admin.committee-members.index');
                default:
                    return redirect()->route('admin.committee-members.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        $this->committeeMember->name = $result['name'];
        $this->committeeMember->phone = $result['mobile_no'];
        $this->committeeMember->email = $result['email'];
        $this->committeeMember->gender = $result['gender'];
        $this->committeeMember->designation = $result['designation'] ?? "";
    }
}
