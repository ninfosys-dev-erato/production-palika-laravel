<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ConsumerCommitteeTransactionAdminDto;
use Src\Yojana\Models\ConsumerCommitteeTransaction;
use Src\Yojana\Service\ConsumerCommitteeTransactionAdminService;

class ConsumerCommitteeTransactionForm extends Component
{
    use SessionFlash;

    public ?ConsumerCommitteeTransaction $consumerCommitteeTransaction;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'consumerCommitteeTransaction.project_id' => ['required'],
    'consumerCommitteeTransaction.type' => ['required'],
    'consumerCommitteeTransaction.date' => ['required'],
    'consumerCommitteeTransaction.amount' => ['required'],
    'consumerCommitteeTransaction.remarks' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'consumerCommitteeTransaction.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'consumerCommitteeTransaction.type.required' => __('yojana::yojana.type_is_required'),
            'consumerCommitteeTransaction.date.required' => __('yojana::yojana.date_is_required'),
            'consumerCommitteeTransaction.amount.required' => __('yojana::yojana.amount_is_required'),
            'consumerCommitteeTransaction.remarks.required' => __('yojana::yojana.remarks_is_required'),
        ];
    }

    public function render(){
        return view("consumer-committee-transactions::projects.form");
    }

    public function mount(ConsumerCommitteeTransaction $consumerCommitteeTransaction,Action $action)
    {
        $this->consumerCommitteeTransaction = $consumerCommitteeTransaction;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ConsumerCommitteeTransactionAdminDto::fromLiveWireModel($this->consumerCommitteeTransaction);
        $service = new ConsumerCommitteeTransactionAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Consumer Committee Transaction Created Successfully");
                return redirect()->route('admin.consumer_committee_transactions.index');
                break;
            case Action::UPDATE:
                $service->update($this->consumerCommitteeTransaction,$dto);
                $this->successFlash("Consumer Committee Transaction Updated Successfully");
                return redirect()->route('admin.consumer_committee_transactions.index');
                break;
            default:
                return redirect()->route('admin.consumer_committee_transactions.index');
                break;
        }
    }
}
