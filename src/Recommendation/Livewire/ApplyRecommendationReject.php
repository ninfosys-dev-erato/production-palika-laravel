<?php

namespace Src\Recommendation\Livewire;

use App\Services\ImageService;
use App\Traits\SessionFlash;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Recommendation\DTO\ApplyRecommendationShowDto;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationAdminService;
use Src\Recommendation\Services\RecommendationService;
use Src\Settings\Models\Form;

class ApplyRecommendationReject extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ApplyRecommendation $applyRecommendation = null;
    public ?Form $form = null;
    public bool $showBillUpload = false;
    public string $rejectionReason = '';
    public $bill;
    public $ltax_ebp_code;


    public function mount(ApplyRecommendation $applyRecommendation)
    {
        $this->applyRecommendation = $applyRecommendation;
        $this->rejectionReason = $applyRecommendation->rejected_reason ?? '';
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:255']);
        try{
            $this->applyRecommendation->rejected_reason = $this->rejectionReason;
            $dto = ApplyRecommendationShowDto::fromModel($this->applyRecommendation);
            $service = new RecommendationAdminService();
            $service->reject($this->applyRecommendation, $dto);
            $this->successFlash( __('recommendation::recommendation.recommendation_rejected_successfully'));
            return redirect()->route('admin.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


    public function render()
    {
        return view("Recommendation::livewire.apply-recommendation.reject");
    }
}
