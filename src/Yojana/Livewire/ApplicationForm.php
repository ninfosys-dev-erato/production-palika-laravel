<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ApplicationAdminDto;
use Src\Yojana\Models\Application;
use Src\Yojana\Models\BankDetail;
use Src\Yojana\Service\ApplicationAdminService;

class ApplicationForm extends Component
{
    use SessionFlash;

    public ?Application $application;
    public ?Action $action;
    public $banks;

    public function rules(): array
    {
        return [
            'application.applicant_name' => ['required'],
            'application.address' => ['required'],
            'application.mobile_number' => ['required'],
            'application.bank_id' => ['required'],
            'application.account_number' => ['required'],
            'application.is_employee' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'application.applicant_name.required' => __('yojana::yojana.applicant_name_is_required'),
            'application.address.required' => __('yojana::yojana.address_is_required'),
            'application.mobile_number.required' => __('yojana::yojana.mobile_number_is_required'),
            'application.bank_id.required' => __('yojana::yojana.bank_id_is_required'),
            'application.account_number.required' => __('yojana::yojana.account_number_is_required'),
            'application.is_employee.required' => __('yojana::yojana.is_employee_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.applications.form");
    }

    public function mount(Application $application, Action $action)
    {
        $this->application = $application;
        $this->action = $action;
        $this->banks = BankDetail::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ApplicationAdminDto::fromLiveWireModel($this->application);
        $service = new ApplicationAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.application_created_successfully'));
                return redirect()->route('admin.applications.index');
                break;
            case Action::UPDATE:
                $service->update($this->application, $dto);
                $this->successFlash(__('yojana::yojana.application_updated_successfully'));
                return redirect()->route('admin.applications.index');
                break;
            default:
                return redirect()->route('admin.applications.index');
                break;
        }
    }
}
