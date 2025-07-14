<?php

namespace Frontend\CustomerPortal\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Services\RecommendationService;
use Src\Recommendation\Traits\RecommendationTemplate;

class CustomerApplyRecommendationPrint extends Component
{
    use SessionFlash, RecommendationTemplate;
    public ?ApplyRecommendation $applyRecommendation;
    public $letter;
    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation->load('recommendation.form', 'recommendation.acceptedBy', 'recommendation.notifyTo', 'customer.kyc', 'reviewedBy', 'acceptedBy');;
       
        $this->letter = $applyRecommendation->additional_letter ?? $this->resolveRecommendationTemplate( $this->applyRecommendation);

    }
    public function render(){
        return view('CustomerPortal.Recommendation::livewire.customerApplyRecommendation.print');
    }
}