<?php

namespace Src\FuelSettings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FuelSettings\DTO\TokenAdminDto;
use Src\FuelSettings\Service\TokenAdminService;
use Src\FuelSettings\Models\Token;

class TokenForm extends Component
{
    use SessionFlash;

    public ?Token $token;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'token.token_no' => ['required'],
            'token.fiscal_year_id' => ['required'],
            'token.tokenable_type' => ['required'],
            'token.tokenable_id' => ['required'],
            'token.organization_id' => ['required'],
            'token.fuel_quantity' => ['required'],
            'token.fuel_type' => ['required'],
            'token.status' => ['required'],
            'token.accepted_at' => ['required'],
            'token.accepted_by' => ['required'],
            'token.reviewed_at' => ['required'],
            'token.reviewed_by' => ['required'],
            'token.expires_at' => ['required'],
            'token.redeemed_at' => ['required'],
            'token.redeemed_by' => ['required'],
            'token.ward_no' => ['required'],
        ];
    }

    public function render()
    {
        return view("FuelSettings::livewire.token-form");
    }

    public function mount(Token $token, Action $action)
    {
        // $uniqueCode = uniqid(time() . '_');
        $this->token = $token;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = TokenAdminDto::fromLiveWireModel($this->token);
            $service = new TokenAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Token Created Successfully");
                    return redirect()->route('admin.tokens.index');
                case Action::UPDATE:
                    $service->update($this->token, $dto);
                    $this->successFlash("Token Updated Successfully");
                    return redirect()->route('admin.tokens.index');
                default:
                    return redirect()->route('admin.tokens.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
