<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Services\RecommendationService;
use Src\Recommendation\Traits\RecommendationTemplate;

class ApplyRecommendationPrint extends Component
{
    use SessionFlash, RecommendationTemplate;
    public ?ApplyRecommendation $applyRecommendation;
    public bool $preview;
    public $letter;
    public $styles;
    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation->load('recommendation.form', 'recommendation.acceptedBy', 'recommendation.notifyTo', 'customer.kyc', 'reviewedBy', 'acceptedBy');;
        $this->preview = true;
        $this->letter = $applyRecommendation->additional_letter ?? $this->resolveRecommendationTemplate($this->applyRecommendation);
        $this->styles = $applyRecommendation->recommendation?->form?->styles ?? "";
    }
    public function render()
    {
        return view('Recommendation::livewire.apply-recommendation.print');
    }

    public function resetLetter()
    {
        $this->letter = $this->resolveRecommendationTemplate($this->applyRecommendation);
        $this->dispatch('update-editor', ['letter' => $this->letter]);
        $this->successToast(__('recommendation::recommendation.reset_successfully'));
    }
    #[On('print-recommendation')]
    public function print()
    {
        $service = new RecommendationService();
        return $service->getLetter($this->applyRecommendation, 'web');
    }

    public function save()
    {
        //        $this->letter = strip_tags( $this->letter);
        $this->applyRecommendation->additional_letter = $this->letter;
        $this->applyRecommendation->save();
        $this->successToast(__('recommendation::recommendation.updated_successfully'));
    }

    public function togglePreview()
    {
        $this->preview = $this->preview ? false : true;
    }
}
