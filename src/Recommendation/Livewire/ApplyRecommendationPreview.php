<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Services\RecommendationService;
use Src\Recommendation\Traits\RecommendationTemplate;

class ApplyRecommendationPreview extends Component
{
    use SessionFlash, RecommendationTemplate;
    public ?ApplyRecommendation $applyRecommendation;
    public bool $preview;
    public string $letter;
    public string $template;

    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation;
        $this->template = $this->resolveRecommendationTemplate($applyRecommendation);
    }
    public function render()
    {
        return view('Recommendation::livewire.apply-recommendation.preview');
    }

    #[On('print-preview-recommendation')]
    public function print()
    {
        $service = new RecommendationService();
        return $service->getLetter($this->applyRecommendation, 'web');
    }
}
