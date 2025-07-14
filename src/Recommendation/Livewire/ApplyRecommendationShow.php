<?php

namespace Src\Recommendation\Livewire;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Recommendation\DTO\ApplyRecommendationShowDto;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationAdminService;
use Src\Recommendation\Services\RecommendationService;
use Src\Settings\Models\Form;

class ApplyRecommendationShow extends Component
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
        $this->showBillUpload = $this->applyRecommendation->status == RecommendationStatusEnum::SENT_FOR_PAYMENT->value;
    }
    #[On('send-for-payment')]
    public function sendForPayment()
    {
        if(can('recommendation_status_edit')){
            $this->showBillUpload = true;
            $this->applyRecommendation->status = RecommendationStatusEnum::SENT_FOR_PAYMENT->value;
            $service = new RecommendationAdminService();
            try{
                $service->sentForPayment($this->applyRecommendation);
                $this->successFlash(__('recommendation::recommendation.successfully_sent_for_payment'));
                return redirect()->route('admin.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
            }catch (\Throwable $e){
                logger($e->getMessage());
                $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
            }
        }
    }

    #[On('approve-recommendation')]
    public function approve()
    {
        if(can('recommendation_approve')){
            $this->applyRecommendation->status = RecommendationStatusEnum::ACCEPTED->value;
            $service = new RecommendationAdminService();
            try{
                $service->accept($this->applyRecommendation);
                $this->successFlash(__('recommendation::recommendation.successfully_accepted'));
                return redirect()->route('admin.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
            }catch (\Throwable $e){
                logger($e->getMessage());
                $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
            }
        }else{
            $this->errorFlash(__('recommendation::recommendation.you_are_not_authorized_to_approve_this_recommendation'));
        }

    }
    public function render()
    {
        return view("Recommendation::livewire.apply-recommendation.show");
    }
}
