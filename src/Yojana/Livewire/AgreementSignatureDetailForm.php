<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\AgreementSignatureDetailAdminController;
use Src\Yojana\DTO\AgreementSignatureDetailAdminDto;
use Src\Yojana\Models\AgreementSignatureDetail;
use Src\Yojana\Service\AgreementSignatureDetailAdminService;

class AgreementSignatureDetailForm extends Component
{
    use SessionFlash;

    public ?AgreementSignatureDetail $agreementSignatureDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'agreementSignatureDetail.agreement_id' => ['required'],
    'agreementSignatureDetail.signature_party' => ['required'],
    'agreementSignatureDetail.name' => ['required'],
    'agreementSignatureDetail.position' => ['required'],
    'agreementSignatureDetail.address' => ['required'],
    'agreementSignatureDetail.contact_number' => ['required'],
    'agreementSignatureDetail.date' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'agreementSignatureDetail.agreement_id.required' => __('yojana::yojana.agreement_id_is_required'),
            'agreementSignatureDetail.signature_party.required' => __('yojana::yojana.signature_party_is_required'),
            'agreementSignatureDetail.name.required' => __('yojana::yojana.name_is_required'),
            'agreementSignatureDetail.position.required' => __('yojana::yojana.position_is_required'),
            'agreementSignatureDetail.address.required' => __('yojana::yojana.address_is_required'),
            'agreementSignatureDetail.contact_number.required' => __('yojana::yojana.contact_number_is_required'),
            'agreementSignatureDetail.date.required' => __('yojana::yojana.date_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.agreement-signature-details-form");
    }

    public function mount(AgreementSignatureDetail $agreementSignatureDetail,Action $action)
    {
        $this->agreementSignatureDetail = $agreementSignatureDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = AgreementSignatureDetailAdminDto::fromLiveWireModel($this->agreementSignatureDetail);
        $service = new AgreementSignatureDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.agreement_signature_detail_created_successfully'));
                return redirect()->route('admin.agreement_signature_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->agreementSignatureDetail,$dto);
                $this->successFlash(__('yojana::yojana.agreement_signature_detail_updated_successfully'));
                return redirect()->route('admin.agreement_signature_details.index');
                break;
            default:
                return redirect()->route('admin.agreement_signature_details.index');
                break;
        }
    }
}
