<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Employees\Models\Employee;
use Src\Yojana\DTO\CommitteeMemberAdminDto;
use Src\Yojana\Models\CommitteeMember;
use Src\Yojana\Service\CommitteeMemberAdminService;

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
            'committeeMember.committee_id.required' => __('yojana::yojana.the_committee_id_is_required'),
            'committeeMember.name.required' => __('yojana::yojana.the_name_field_is_required'),
            'committeeMember.name.string' => __('yojana::yojana.the_name_must_be_a_string'),
            'committeeMember.designation.string' => __('yojana::yojana.the_designation_must_be_a_string'),
            'committeeMember.phone.string' => __('yojana::yojana.the_phone_must_be_a_string'),
            'committeeMember.phone.required' => __('yojana::yojana.the_phone_field_is_required'),
            'committeeMember.photo.string' => __('yojana::yojana.the_photo_must_be_a_string'),
            'committeeMember.email.email' => __('yojana::yojana.the_email_must_be_a_valid_email_address'),
            'committeeMember.province_id.required' => __('yojana::yojana.the_province_is_required'),
            'committeeMember.province_id.integer' => __('yojana::yojana.the_province_must_be_an_integer'),
            'committeeMember.province_id.exists' => __('yojana::yojana.the_selected_province_is_invalid'),
            'committeeMember.district_id.required' => __('yojana::yojana.the_district_is_required'),
            'committeeMember.district_id.integer' => __('yojana::yojana.the_district_must_be_an_integer'),
            'committeeMember.district_id.exists' => __('yojana::yojana.the_selected_district_is_invalid'),
            'committeeMember.local_body_id.required' => __('yojana::yojana.the_local_body_is_required'),
            'committeeMember.local_body_id.integer' => __('yojana::yojana.the_local_body_must_be_an_integer'),
            'committeeMember.local_body_id.exists' => __('yojana::yojana.the_selected_local_body_is_invalid'),
            'committeeMember.ward_no.integer' => __('yojana::yojana.the_ward_number_must_be_an_integer'),
            'committeeMember.tole.string' => __('yojana::yojana.the_tole_must_be_a_string'),
            'committeeMember.position.required' => __('yojana::yojana.the_position_is_required'),
            'committeeMember.position.integer' => __('yojana::yojana.the_position_must_be_an_integer'),
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
        $this->committeeMember->phone = $this->convertNepaliToEnglish($this->committeeMember->phone);
        $dto = CommitteeMemberAdminDto::fromLiveWireModel($this->committeeMember);
        $service = new CommitteeMemberAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.committee_member_created_successfully'));
                if (!$this->isModalForm) {
                    return redirect()->route('admin.committee-members.index');
                }
                break;
            case Action::UPDATE:
                $service->update($this->committeeMember, $dto);
                $this->successFlash(__('yojana::yojana.committee_member_updated_successfully'));
                return redirect()->route('admin.committee-members.index');
                break;
            default:
                return redirect()->route('admin.committee-members.index');
                break;
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
