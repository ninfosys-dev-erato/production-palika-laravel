<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;

use Livewire\Component;
use Src\TokenTracking\Enums\TokenStageEnum;
use Src\TokenTracking\Enums\TokenStatusEnum;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\RegisterTokenAdminService;


class TokenShow extends Component
{
    use SessionFlash, HelperDate;

    public RegisterToken $registerToken;

    public bool $isStageChange = false;
    public function rules(): array
    {
        return [
            'registerToken.stage' => 'nullable',
            'registerToken.status' => 'nullable',

        ];
    }

    public function render()
    {
        return view("TokenTracking::livewire.show");
    }

    public function mount(RegisterToken $registerToken) 
    {
        $this->registerToken = $registerToken;
       
    }

    public function updateStage()
    {
        $service = new RegisterTokenAdminService();
        $tokenStageEnum = TokenStageEnum::tryFrom($this->registerToken->stage);
        if($service->updateStage($this->registerToken, $tokenStageEnum)){
            $this->successToast(__('tokentracking::tokentracking.stage_updated_successfully'));
        }else{
            $this->errorFlash(__('tokentracking::tokentracking.an_error_occurred_during_operation_please_try_again_later'));
        }
    }
    public function updateStatus()
    {
        $service = new RegisterTokenAdminService();
        $tokenStatusEnum = TokenStatusEnum::tryFrom($this->registerToken->status);
        if($service->updateStatus($this->registerToken, $tokenStatusEnum)){
            $this->successToast(__('tokentracking::tokentracking.status_updated_successfully'));
        }else{
            $this->errorFlash(__('tokentracking::tokentracking.an_error_occurred_during_operation_please_try_again_later'));
        }

        
    }
}
