<?php

namespace Frontend\CustomerPortal\Recommendation\Livewire;

use App\Facades\ImageServiceFacade;
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
use Livewire\Attributes\On;

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
        $this->showBillUpload = $this->applyRecommendation->status == RecommendationStatusEnum::SENT_FOR_PAYMENT;
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:255']);
        try{
            $this->applyRecommendation->rejected_reason = $this->rejectionReason;
            $dto = ApplyRecommendationShowDto::fromModel($this->applyRecommendation);
            $service = new RecommendationAdminService();
            $service->reject($this->applyRecommendation, $dto);
            $this->successFlash(__('Recommendation rejected successfully.'));
            return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function sendForPayment()
    {
        $this->showBillUpload = $this->applyRecommendation->status == RecommendationStatusEnum::SENT_FOR_PAYMENT;
        $service = new RecommendationAdminService();
        $service->sentForPayment($this->applyRecommendation);
        $this->successFlash(__('recommendation::recommendation.successfully_sent_for_payment'));
        return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
    }

    public function sendToApprover()
    {
        $service = new RecommendationAdminService();
        $service->review($this->applyRecommendation);
        $this->successFlash( __('Successfully Reviewed.'));
        return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
    }

    public function approve()
    {
        $service = new RecommendationAdminService();
        $service->accept($this->applyRecommendation);
        $this->successFlash( __('Successfully Accepted.'));
        return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
    }

    public function uploadBill()
    {
        $this->validate([
            'ltax_ebp_code' => 'required',
            'bill' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        try{
            $path = ImageServiceFacade::compressAndStoreImage($this->bill, config('src.Recommendation.recommendation.path'), 'local');
            $this->applyRecommendation->bill = $path;
            $this->applyRecommendation->ltax_ebp_code = $this->ltax_ebp_code;
            $dto = ApplyRecommendationShowDto::fromModel($this->applyRecommendation);
            $service = new RecommendationAdminService();
            $service->uploadBill($this->applyRecommendation, $dto);
            $this->successFlash('recommendation::recommendation.bill_uploaded_successfully');
            return redirect()->route('customer.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function render()
    {
        return view("CustomerPortal.Recommendation::livewire.customerApplyRecommendation.show");
    }

    #[On('print-customer-recommendation')]
    public function print()
    {
        $service = new RecommendationService();
        return $service->getLetter($this->applyRecommendation,'web');
    }
}