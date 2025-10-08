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
    public string $styles;

    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation->load('recommendation');
        $rawTemplate = $this->resolveRecommendationTemplate($applyRecommendation);
        $this->template = $this->cleanTemplate($rawTemplate);
        $this->styles = $applyRecommendation->recommendation?->form?->styles ?? "";
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

    private function cleanTemplate(string $template): string
{
    // Remove empty <p></p> tags (including &nbsp; or spaces)
    $template = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $template);

    // Remove all {{...}} placeholder tags
    $template = preg_replace('/{{[^}]*}}/', '', $template);

    // Trim whitespace at the start and end
    return trim($template);
}
}
