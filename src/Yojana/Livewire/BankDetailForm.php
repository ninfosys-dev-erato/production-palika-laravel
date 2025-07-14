<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\BankDetailAdminDto;
use Src\Yojana\Models\BankDetail;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Service\BankDetailAdminService;

class BankDetailForm extends Component
{
    use SessionFlash;

    public ?BankDetail $bankDetail;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
    'bankDetail.title' => ['required'],
    'bankDetail.branch' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'bankDetail.title.required' => __('yojana::yojana.title_is_required'),
            'bankDetail.branch.required' => __('yojana::yojana.branch_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.bank-details.form");
    }

    public function mount(BankDetail $bankDetail,Action $action)
    {
        $this->bankDetail = $bankDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = BankDetailAdminDto::fromLiveWireModel($this->bankDetail);
        $service = new BankDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.bank_detail_created_successfully'));
//                return redirect()->route('admin.bank_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->bankDetail,$dto);
                $this->successFlash(__('yojana::yojana.bank_detail_updated_successfully'));
//                return redirect()->route('admin.bank_details.index');
                break;
            default:
                return redirect()->route('admin.bank_details.index');
                break;
        }
        $this->dispatch('close-modal');

    }
    #[On('edit-bank-detail')]
    public function editBankDetail(BankDetail $bankDetail){
        $this->bankDetail = $bankDetail;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetBankDetail()
    {
        $this->reset(['bankDetail', 'action']);
        $this->bankDetail = new BankDetail();
    }
}
