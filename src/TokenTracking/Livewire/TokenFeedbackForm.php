<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\TokenTracking\DTO\TokenFeedbackAdminDto;
use Src\TokenTracking\Enums\CitizenSatisfactionEnum;
use Src\TokenTracking\Enums\ServiceAccesibilityEnum;
use Src\TokenTracking\Enums\ServiceQualityEnum;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Models\TokenFeedback;
use Src\TokenTracking\Service\TokenFeedbackAdminService;

class TokenFeedbackForm extends Component
{
    use SessionFlash;

    public ?TokenFeedback $tokenFeedback = null;
    public ?RegisterToken $registerToken = null;
    public ?string $tokenNumber;
    public ?string $tokenDate;
    public ?string $mobileNumber;
    public ?Action $action;
    public bool $preview = false;
    public $serviceAccesibilty;
    public $serviceQuality;
    public $citizenSatisfaction;

    public function rules(): array
    {
        return [
            'tokenFeedback.token_id' => ['required'],
            'tokenFeedback.feedback' => ['nullable'],
            'tokenFeedback.rating' => ['nullable'],
            'tokenFeedback.service_quality' => ['required'],
            'tokenFeedback.service_accesibility' => ['required'],
            'tokenFeedback.citizen_satisfaction' => ['required'],
        ];
    }

    public function render()
    {
        return view("TokenTracking::livewire.token-feedbacks-form");
    }

    public function mount(TokenFeedback $tokenFeedback, Action $action, RegisterToken $registerToken)
    {
        // Initialize tokenFeedback if it's not already set
        // if (!$this->tokenFeedback) {
        //     $this->tokenFeedback = new TokenFeedback(); // or fetch an existing TokenFeedback if needed
        // } else {
        //     $this->tokenFeedback = $tokenFeedback;
        // }
        $tokenFeedback->load('token.tokenHolder'); // load nested relationship safely
        $this->tokenFeedback = $tokenFeedback ?? new TokenFeedback();
        $this->registerToken = $registerToken ?? new RegisterToken();


        $this->action = $action;

        $this->tokenNumber = "";
        $this->tokenDate = "";
        $this->mobileNumber = "";


        $this->serviceAccesibilty = ServiceAccesibilityEnum::getValuesWithLabels();
        $this->serviceQuality = ServiceQualityEnum::getValuesWithLabels();
        $this->citizenSatisfaction = CitizenSatisfactionEnum::getValuesWithLabels();

        if ($this->tokenFeedback->token) {
            $this->tokenNumber = $this->tokenFeedback->token->token ?? '';
            $this->tokenDate = $this->tokenFeedback->token->date_en ?? '';
            $this->mobileNumber = $this->tokenFeedback->token->tokenHolder->mobile_no ?? '';
        }


        if ($this->action == Action::UPDATE) {
            $this->preview = true;
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = TokenFeedbackAdminDto::fromLiveWireModel($this->tokenFeedback);
            $service = new TokenFeedbackAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tokentracking::tokentracking.token_feedback_created_successfully'));
                    $this->resetForm();
                case Action::UPDATE:
                    $service->update($this->tokenFeedback, $dto);
                    $this->successFlash(__('tokentracking::tokentracking.token_feedback_updated_successfully'));
                    return redirect()->route('admin.token_feedbacks.index');
                default:
                    return redirect()->route('admin.token_feedbacks.index');
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function findToken()
    {
        // Clear previous errors before new validation
        $this->resetErrorBag();
        // Manual validation of fields using Livewire's addError method
        if (empty($this->tokenNumber)) {
            $this->addError('tokenNumber', 'Token number is required.');
        }

        if (empty($this->tokenDate)) {
            $this->addError('tokenDate', 'Token date is required.');
        }

        if (empty($this->mobileNumber)) {
            $this->addError('mobileNumber', 'Mobile number is required.');
        }
        // If there are validation errors, stop further processing
        if ($this->getErrorBag()->count() > 0) {
            return;
        }

        // Query to find the RegisterToken based on the criteria
        $this->registerToken = RegisterToken::where('token', $this->tokenNumber)
            ->where('date', $this->tokenDate)
            ->whereHas('tokenHolder', function ($query) {
                $query->where('mobile_no', $this->mobileNumber); // Assuming $this->mobileNumber contains the value to search for
            })
            ->first();


        if ($this->registerToken) {
            $this->registerToken->load('tokenHolder');
            $this->tokenFeedback ??= new TokenFeedback();
            $this->tokenFeedback->token_id = $this->registerToken->id;
            $this->preview = true;
            $this->successToast(__('tokentracking::tokentracking.token_data_found'));
        }

        // If no RegisterToken found, display error
        if (!$this->registerToken) {
            $this->errorToast(__('tokentracking::tokentracking.token_feedback_not_found'));
            return;
        }

        // Assign the found RegisterToken's id to token_id in TokenFeedback
        // $this->tokenFeedback->token_id = $this->registerToken->id;
    }


    public function setToken(RegisterToken $registerToken)
    {
        $this->registerToken = $registerToken;
        $this->tokenNumber = $registerToken->token;
        $this->tokenDate = $registerToken->date_en;
        $this->mobileNumber = $registerToken->tokenHolder->mobile_no;
        $this->findToken();
    }
    #[On('edit-tokenFeedback')]
    public function addTokenFeedBack(RegisterToken $registerToken)
    {
        $this->registerToken = $registerToken;
        $this->setToken($registerToken);
        $this->dispatch('open-modal');
    }

    #[On('reset-tokenFeedback-form')]
    public function resetForm()
    {
        // Clear all form data
        $this->tokenFeedback = new TokenFeedback();
        $this->tokenNumber = "";
        $this->tokenDate = "";
        $this->mobileNumber = "";
        $this->preview = false;
        $this->dispatch('close-modal');
    }
}
