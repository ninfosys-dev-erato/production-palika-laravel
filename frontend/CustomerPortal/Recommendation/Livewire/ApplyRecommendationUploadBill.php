<?php

namespace Frontend\CustomerPortal\Recommendation\Livewire;

use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Recommendation\DTO\ApplyRecommendationShowDto;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Services\RecommendationAdminService;
use Src\Settings\Models\Form;

class ApplyRecommendationUploadBill extends Component
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
        $this->showBillUpload = $this->applyRecommendation->status == RecommendationStatusEnum::SENT_FOR_PAYMENT;
    }


    public function sendToApprover()
    {
        if(can('recommendation_apply status')) {
            $service = new RecommendationAdminService();
            $service->review($this->applyRecommendation);
            $this->errorFlash( __('Successfully Reviewed.'));
            return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }
    }


    public function uploadBill()
    {
        $this->validate([
            'ltax_ebp_code' => 'required',
            'bill' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);
        try{
            $path = ImageServiceFacade::compressAndStoreImage($this->bill, config('src.Recommendation.recommendation.bill'), getStorageDisk('public'));
            $this->applyRecommendation->bill = $path;
            $this->applyRecommendation->ltax_ebp_code = $this->ltax_ebp_code;
            $dto = ApplyRecommendationShowDto::fromModel($this->applyRecommendation);
            $service = new RecommendationAdminService();
            $service->uploadBill($this->applyRecommendation, $dto);

            $this->successFlash(__('recommendation::recommendation.bill_uploaded_successfully'));
            return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function render()
    {
        return view("CustomerPortal.Recommendation::livewire.customerApplyRecommendation.bill");
    }
}
