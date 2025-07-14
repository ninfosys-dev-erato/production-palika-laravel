<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TokenTracking\DTO\TokenLogAdminDto;
use Src\TokenTracking\Models\TokenLog;
use Src\TokenTracking\Service\TokenLogAdminService;

class TokenLogForm extends Component
{
    use SessionFlash;

    public ?TokenLog $tokenLog;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'tokenLog.token_id' => ['required'],
    'tokenLog.old_status' => ['required'],
    'tokenLog.new_status' => ['required'],
    'tokenLog.status' => ['required'],
    'tokenLog.stage_status' => ['required'],
    'tokenLog.old_branch' => ['required'],
    'tokenLog.new_branch' => ['required'],
];
    }

    public function render(){
        return view("TokenTracking::livewire.tokenlogs--form");
    }

    public function mount(TokenLog $tokenLog,Action $action)
    {
        $this->tokenLog = $tokenLog;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = TokenLogAdminDto::fromLiveWireModel($this->tokenLog);
            $service = new TokenLogAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tokentracking::tokentracking.token_log_created_successfully'));
                    return redirect()->route('admin.token_logs.index');
                case Action::UPDATE:
                    $service->update($this->tokenLog,$dto);
                    $this->successFlash(__('tokentracking::tokentracking.token_log_updated_successfully'));
                    return redirect()->route('admin.token_logs.index');
                default:
                    return redirect()->route('admin.token_logs.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
