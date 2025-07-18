<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\AgreementBeneficiaryAdminController;
use Src\Yojana\DTO\AgreementBeneficiaryAdminDto;
use Src\Yojana\Models\AgreementBeneficiary;
use Src\Yojana\Models\BenefitedMember;
use Src\Yojana\Service\AgreementBeneficiaryAdminService;

class AgreementBeneficiaryForm extends Component
{
    use SessionFlash;

    public ?AgreementBeneficiary $agreementBeneficiary;
    public ?Action $action;
    public $beneficiaries;

    public function rules(): array
    {
        return [
    'agreementBeneficiary.agreement_id' => ['required'],
    'agreementBeneficiary.beneficiary_id' => ['required'],
    'agreementBeneficiary.total_count' => ['required'],
    'agreementBeneficiary.men_count' => ['required'],
    'agreementBeneficiary.women_count' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'agreementBeneficiary.agreement_id.required' => __('yojana::yojana.agreement_id_is_required'),
            'agreementBeneficiary.beneficiary_id.required' => __('yojana::yojana.beneficiary_id_is_required'),
            'agreementBeneficiary.total_count.required' => __('yojana::yojana.total_count_is_required'),
            'agreementBeneficiary.men_count.required' => __('yojana::yojana.men_count_is_required'),
            'agreementBeneficiary.women_count.required' => __('yojana::yojana.women_count_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.agreement-beneficiaries-form");
    }

    public function mount(AgreementBeneficiary $agreementBeneficiary,Action $action)
    {
        $this->beneficiaries = BenefitedMember::whereNUll('deleted_at')->pluck('title','id')->toArray();
        $this->agreementBeneficiary = $agreementBeneficiary;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = AgreementBeneficiaryAdminDto::fromLiveWireModel($this->agreementBeneficiary);
        $service = new AgreementBeneficiaryAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.agreement_beneficiary_created_successfully'));
                return redirect()->route('admin.agreement_beneficiaries.index');
                break;
            case Action::UPDATE:
                $service->update($this->agreementBeneficiary,$dto);
                $this->successFlash(__('yojana::yojana.agreement_beneficiary_updated_successfully'));
                return redirect()->route('admin.agreement_beneficiaries.index');
                break;
            default:
                return redirect()->route('admin.agreement_beneficiaries.index');
                break;
        }
    }
}
