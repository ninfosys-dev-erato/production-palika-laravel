<?php

namespace Src\Customers\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Customers\DTO\CustomerKycDto;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Models\Customer;
use Src\Customers\Models\CustomerKyc;
use Src\Customers\Service\CustomerAdminService;

class CustomerDetailChangeStatusForm extends Component
{
    use SessionFlash;

    public ?CustomerKyc $customerKyc;
    public ?Customer $customer;
    public Action $action;
    
    public array $reason_to_reject = [];
    public function rules(): array
    {
        $rules = [
            'customerKyc.status' => ['required', Rule::in(array_column(KycStatusEnum::cases(), 'value'))],
            'reason_to_reject' => ['nullable', 'array'],
        ];

        if ($this->customerKyc && $this->customerKyc->status->value === 'rejected') {
            $rules['reason_to_reject'] = ['required', 'array'];
        }

        return $rules;
    }

    public function render()
    {
        return view("Customers::livewire.customerDetail.change_status");
    }


    public function setKycStatus(string $status)
    {
        $this->customerKyc->status = $status;

        if ($status === 'accepted') {
            $this->reason_to_reject = [];
        }
    }

    public function mount(CustomerKyc $customerKyc, Customer $customer): void
    {
        $this->customerKyc = $customerKyc;
        $this->customer = $customer;
        $this->action = Action::UPDATE;
        if ($this->customerKyc->status->value === 'rejected') {
            $this->reason_to_reject = json_decode($this->customerKyc->reason_to_reject, true) ?? [];
        } else {
            $this->reason_to_reject = [];
        }
    }

    public function save()
    {
        $this->validate();

        try{
            $dto = CustomerKycDto::buildFromValidatedRequest($this->customerKyc, $this->reason_to_reject);
            
            $this->customerKyc->status = $dto->status->value;
            
            if ($dto->status->value === 'rejected') {
                $this->customerKyc->reason_to_reject = !empty($dto->reason_to_reject) ? implode(', ', $dto->reason_to_reject) : null;
            } else {
                $this->customerKyc->reason_to_reject = null;
            }
            $service = new CustomerAdminService();
            if ($this->action === Action::UPDATE) {
                $service->updateStatus($this->customerKyc, $dto);
                $this->successFlash(__("Customer Detail Status Updated Successfully"));   
            }
            return redirect()->route('admin.customer.detail', $this->customer->id);
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }
}