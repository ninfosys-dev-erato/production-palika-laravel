<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\AgreementGrantAdminController;
use Src\Yojana\DTO\AgreementGrantAdminDto;
use Src\Yojana\Models\AgreementGrant;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Service\AgreementGrantAdminService;

class AgreementGrantForm extends Component
{
    use SessionFlash;

    public ?AgreementGrant $agreementGrant;
    public ?Action $action;
    public $sourceTypes;

    public function rules(): array
    {
        return [
    'agreementGrant.agreement_id' => ['required'],
    'agreementGrant.source_type_id' => ['required'],
    'agreementGrant.material_name' => ['required'],
    'agreementGrant.unit' => ['required'],
    'agreementGrant.amount' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'agreementGrant.agreement_id.required' => __('yojana::yojana.agreement_id_is_required'),
            'agreementGrant.source_type_id.required' => __('yojana::yojana.source_type_id_is_required'),
            'agreementGrant.material_name.required' => __('yojana::yojana.material_name_is_required'),
            'agreementGrant.unit.required' => __('yojana::yojana.unit_is_required'),
            'agreementGrant.amount.required' => __('yojana::yojana.amount_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.agreement-grants-form");
    }

    public function mount(AgreementGrant $agreementGrant,Action $action)
    {
        $this->sourceTypes = SourceType::whereNull('deleted_at')->pluck('title','id')->toArray();
        $this->agreementGrant = $agreementGrant;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = AgreementGrantAdminDto::fromLiveWireModel($this->agreementGrant);
        $service = new AgreementGrantAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.agreement_grant_created_successfully'));
                return redirect()->route('admin.agreement_grants.index');
                break;
            case Action::UPDATE:
                $service->update($this->agreementGrant,$dto);
                $this->successFlash(__('yojana::yojana.agreement_grant_updated_successfully'));
                return redirect()->route('admin.agreement_grants.index');
                break;
            default:
                return redirect()->route('admin.agreement_grants.index');
                break;
        }
    }
}
