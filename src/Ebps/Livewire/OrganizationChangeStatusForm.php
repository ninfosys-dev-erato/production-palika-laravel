<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Ebps\Enums\OrganizationStatusEnum;
use Src\Ebps\Jobs\SendOrganizationStatusMail;
use Src\Ebps\Models\Organization;

class OrganizationChangeStatusForm extends Component
{
    use SessionFlash;
    protected $listeners = ['setStatus'];

    public ?Organization $organization;
    public ?Customer $customer;
    public Action $action;
    public bool $rejectModal = false;

    public $reason_to_reject;
    public function rules(): array
    {
        $rules = [
            'organization.status' => ['required', Rule::in(array_column(OrganizationStatusEnum::cases(), 'value'))],
            'reason_to_reject' => ['nullable'],
        ];

        if ($this->organization && $this->organization?->status?->value === 'rejected') {
            $rules['reason_to_reject'] = ['required'];
        }

        return $rules;
    }

    public function render()
    {
        return view("Ebps::livewire.organization.change-status-form");
    }

    public function setStatus()
    {
        if($this->organization->status->value == 'rejected')
        {
            $this->rejectModal = !$this->rejectModal;
            $this->save();
        }else{
            $this->save();
        }

    }

    public function mount(Organization $organization): void
    {

        $this->organization = $organization;
        $this->action = Action::UPDATE;
        if ($this->organization?->status?->value === 'rejected') {
            $this->reason_to_reject = $this->organization?->reason_to_reject;
        } else {
            $this->reason_to_reject = null;

        }
    }

    public function save()
    {
        $data =  $this->validate();
        try{

            $this->organization->status = $data['organization']['status'];
            if ($this->organization?->status === 'rejected') {
                $this->organization->reason_to_reject = !empty($data['reason_to_reject']) ? implode(', ', $data['reason_to_reject']) : null;
            } else {
                $this->organization->reason_to_reject = null;
            }

            $this->organization->save();

            dispatch(new SendOrganizationStatusMail($this->organization));

            $this->successFlash(__('ebps::ebps.status_updated_successfully'));

            return redirect()->route('admin.ebps.organizations.show', $this->organization->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
