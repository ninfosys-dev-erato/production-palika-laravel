<?php

namespace Frontend\CustomerPortal\Home\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
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
        return view("CustomerPortal.Home::livewire.token-feedbacks-form");
    }

    public function mount(TokenFeedback $tokenFeedback, Action $action)
    {
        // Initialize tokenFeedback if it's not already set
        // if (!$this->tokenFeedback) {
        //     $this->tokenFeedback = new TokenFeedback(); // or fetch an existing TokenFeedback if needed
        // } else {
        //     $this->tokenFeedback = $tokenFeedback;
        // }
        $this->tokenFeedback = $tokenFeedback ?? new TokenFeedback();
        $this->registerToken ??= new RegisterToken();
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
        try{
            $dto = TokenFeedbackAdminDto::fromLiveWireModel($this->tokenFeedback);
            $service = new TokenFeedbackAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Token Feedback Created Successfully"));
                    // Clear all form data
                    $this->tokenFeedback = new TokenFeedback();
                    $this->tokenNumber = "";
                    $this->tokenDate = "";
                    $this->mobileNumber = "";
                    $this->preview = false;
                    break;
                case Action::UPDATE:
                    $service->update($this->tokenFeedback, $dto);
                    $this->successFlash(__("Token Feedback Updated Successfully"));
                    break;
                default:
                    break;
            }
        }catch (\Throwable $e){
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
            ->where('date_en', $this->tokenDate)
            ->whereHas('tokenHolder', function ($query) {
                $query->where('mobile_no', $this->mobileNumber); // Assuming $this->mobileNumber contains the value to search for
            })
            ->first();

        if ($this->registerToken) {
            $this->registerToken->load('tokenHolder');
            $this->preview = true;
            $this->successToast(__("Token Data Found"));
        }

        // If no RegisterToken found, display error
        if (!$this->registerToken) {
            $this->errorToast(__("Token Feedback Not Found"));
            return;
        }

        // Assign the found RegisterToken's id to token_id in TokenFeedback
        $this->tokenFeedback->token_id = $this->registerToken->id;
    }
}
