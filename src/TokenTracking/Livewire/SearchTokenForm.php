<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;

use Carbon\Carbon;
use Livewire\Component;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Enums\TokenStageEnum;
use Src\TokenTracking\Enums\TokenStatusEnum;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\RegisterTokenAdminService;



class SearchTokenForm extends Component
{
    use SessionFlash, HelperDate;

    public $token;
    public $customer;
    public $startDate;
    public $endDate;

    public $registerTokenData = [];
    public $tokenHolder;

    public $selectedTokenId;

    public $stages = [];
    public $statuses = [];

    public function rules(): array
    {
        return [
            'startDate' => ['required', 'before_or_equal:endDate'],
            'endDate' => ['required', 'after_or_equal:startDate'],
        ];
    }

    public function render()
    {
        return view("TokenTracking::livewire.search-token-form");
    }

    public function mount()
    {
        $this->registerTokenData = [];
        foreach ($this->registerTokenData as $token) {
            $this->stages[$token->id] = $token->stage;
            $this->statuses[$token->id] = $token->status;
        }
    }

    public function search()
    {
        $startDate = $this->startDate ? Carbon::parse($this->bsToAd($this->startDate))->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->bsToAd($this->endDate))->endOfDay() : null;

        $query = RegisterToken::with('tokenHolder', 'currentBranch');
        if ($this->token) {
            $query->where('token', $this->token);
        }

        if ($this->customer) {
            $query->whereHas('tokenHolder', function ($q) {
                $q->where('mobile_no', $this->customer);
            });
        }

        if ($startDate && $endDate) {
            $this->validate();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $query->whereDate('created_at', today());
        }

        $this->registerTokenData = $query->get();
        $this->stages = [];
        $this->statuses = [];

        foreach ($this->registerTokenData as $token) {
            $this->stages[$token->id] = $token->stage;
            $this->statuses[$token->id] = $token->status;
        }
    }

    public function updateToken(int $id)
    {
        $registerToken = RegisterToken::findOrFail($id);
        $stage = $this->stages[$id];
        $status = $this->statuses[$id];
        $this->updateStatus($status, $registerToken);

        $this->successFlash(__('tokentracking::tokentracking.register_token_updated_successfully'));
        $this->clear();
    }

    public function stageChange(int $id)
    {
        $registerToken = RegisterToken::findOrFail($id);

        $token = $this->updateStage($this->stages[$id], $registerToken);
        $this->updateStageStatus($id, $token);
    }

    public function updateStageStatus(int $id, $registerToken)
    {
        $this->statuses[$id] = TokenStatusEnum::PROCESSING->value;

        $registerToken->update([
            'status' => TokenStatusEnum::PROCESSING->value
        ]);
        $this->statuses[$id] = $registerToken->status;
    }
    public function updateStage($stage, $registerToken)
    {
        $service = new RegisterTokenAdminService();
        $tokenStageEnum = TokenStageEnum::tryFrom($stage);

        return $service->updateStage($registerToken, $tokenStageEnum);
    }
    public function updateStatus($status, $registerToken)
    {
        $service = new RegisterTokenAdminService();
        $tokenStatusEnum = TokenStatusEnum::tryFrom($status);

        return $service->updateStatus($registerToken, $tokenStatusEnum);
    }

    public function clear()
    {
        $this->token = null;
        $this->customer = null;
        $this->registerTokenData = [];
        $this->statuses = null;
        $this->stages = null;
        $this->tokenHolder = null;
        $this->startDate = null;
        $this->endDate = null;
    }
}
