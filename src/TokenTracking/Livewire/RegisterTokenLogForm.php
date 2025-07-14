<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TokenTracking\Controllers\RegisterTokenLogAdminController;
use Src\TokenTracking\DTO\RegisterTokenLogAdminDto;
use Src\TokenTracking\Models\RegisterTokenLog;
use Src\TokenTracking\Service\RegisterTokenLogAdminService;

class RegisterTokenLogForm extends Component
{
    use SessionFlash;

    public ?RegisterTokenLog $registerTokenLog;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'registerTokenLog.token_id' => ['required'],
    'registerTokenLog.old_branch' => ['required'],
    'registerTokenLog.current_branch' => ['required'],
    'registerTokenLog.old_stage' => ['required'],
    'registerTokenLog.current_stage' => ['required'],
    'registerTokenLog.old_status' => ['required'],
    'registerTokenLog.current_status' => ['required'],
    'registerTokenLog.old_values' => ['required'],
    'registerTokenLog.current_values' => ['required'],
    'registerTokenLog.description' => ['required'],
];
    }

    public function render(){
        return view("TokenTracking::livewire.register-token-logs-form");
    }

    public function mount(RegisterTokenLog $registerTokenLog,Action $action)
    {
        $this->registerTokenLog = $registerTokenLog;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = RegisterTokenLogAdminDto::fromLiveWireModel($this->registerTokenLog);
        $service = new RegisterTokenLogAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('tokentracking::tokentracking.register_token_log_created_successfully'));
                return redirect()->route('admin.register_token_logs.index');
                break;
            case Action::UPDATE:
                $service->update($this->registerTokenLog,$dto);
                $this->successFlash(__('tokentracking::tokentracking.register_token_log_updated_successfully'));
                return redirect()->route('admin.register_token_logs.index');
                break;
            default:
                return redirect()->route('admin.register_token_logs.index');
                break;
        }
    }
}
