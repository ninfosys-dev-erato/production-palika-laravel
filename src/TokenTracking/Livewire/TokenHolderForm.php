<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\TokenTracking\DTO\TokenHolderAdminDto;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\TokenHolderAdminService;

class TokenHolderForm extends Component
{
    use SessionFlash;

    #[Modelable]
    public $tokenHolder;

    public function rules(): array
    {
        return [
            'tokenHolder.name' => ['nullable'],
            'tokenHolder.email' => ['nullable'],
            'tokenHolder.mobile_no' => ['nullable'],
            'tokenHolder.address' => ['nullable'],
        ];
    }
    public function mount(TokenHolder $tokenHolder)
    {
        $this->tokenHolder = $tokenHolder;  // Eloquent model
    }
    public function render(){
        return view("TokenTracking::livewire.token-holders-form");
    }

    public function refresh()
    {
//        $this->tokenHolder?->fresh();
    }
}
