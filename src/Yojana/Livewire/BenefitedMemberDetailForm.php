<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\BenefitedMemberDetailAdminDto;
use Src\Yojana\Models\BenefitedMemberDetail;
use Src\Yojana\Service\BenefitedMemberDetailAdminService;

class BenefitedMemberDetailForm extends Component
{
    use SessionFlash;

    public ?BenefitedMemberDetail $benefitedMemberDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'benefitedMemberDetail.project_id' => ['required'],
    'benefitedMemberDetail.ward_no' => ['required'],
    'benefitedMemberDetail.village' => ['required'],
    'benefitedMemberDetail.dalit_backward_no' => ['required'],
    'benefitedMemberDetail.other_households_no' => ['required'],
    'benefitedMemberDetail.no_of_male' => ['required'],
    'benefitedMemberDetail.no_of_female' => ['required'],
    'benefitedMemberDetail.no_of_others' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'benefitedMemberDetail.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'benefitedMemberDetail.ward_no.required' => __('yojana::yojana.ward_no_is_required'),
            'benefitedMemberDetail.village.required' => __('yojana::yojana.village_is_required'),
            'benefitedMemberDetail.dalit_backward_no.required' => __('yojana::yojana.dalit_backward_no_is_required'),
            'benefitedMemberDetail.other_households_no.required' => __('yojana::yojana.other_households_no_is_required'),
            'benefitedMemberDetail.no_of_male.required' => __('yojana::yojana.no_of_male_is_required'),
            'benefitedMemberDetail.no_of_female.required' => __('yojana::yojana.no_of_female_is_required'),
            'benefitedMemberDetail.no_of_others.required' => __('yojana::yojana.no_of_others_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.benefited-member-detail.form");
    }

    public function mount(BenefitedMemberDetail $benefitedMemberDetail,Action $action)
    {
        $this->benefitedMemberDetail = $benefitedMemberDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = BenefitedMemberDetailAdminDto::fromLiveWireModel($this->benefitedMemberDetail);
        $service = new BenefitedMemberDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Benefited Member Detail Created Successfully");
                return redirect()->route('admin.benefited_member_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->benefitedMemberDetail,$dto);
                $this->successFlash("Benefited Member Detail Updated Successfully");
                return redirect()->route('admin.benefited_member_details.index');
                break;
            default:
                return redirect()->route('admin.benefited_member_details.index');
                break;
        }
    }
}
