<?php

namespace Src\Recommendation\Livewire;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
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

    #[On('send-to-approver')]
    public function sendToApprover()
    {
        if(can('recommendation status')) {
            $service = new RecommendationAdminService();
            $service->review($this->applyRecommendation);
            $this->successFlash(__('recommendation::recommendation.successfully_reviewed'));
            return redirect()->route('admin.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }
    }


    public function uploadBill()
    {
        $this->validate([
            'ltax_ebp_code' => 'nullable|string',
            'bill' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);
        try{

            $path= null;
            if($this->bill){
                $path = FileFacade::saveFile( config('src.Recommendation.recommendation.bill'),'', $this->bill, 'local');
            }

            $this->applyRecommendation->bill = $path ?? null;
            $this->applyRecommendation->ltax_ebp_code = $this->ltax_ebp_code ?? null;
            $this->applyRecommendation->status = RecommendationStatusEnum::BILL_UPLOADED->value;
            $dto = ApplyRecommendationShowDto::fromModel($this->applyRecommendation);
            $service = new RecommendationAdminService();
            $service->uploadBill($this->applyRecommendation, $dto);
            $this->successFlash(__('recommendation::recommendation.bill_uploaded_successfully'));
            return redirect()->route('admin.recommendations.apply-recommendation.show', $this->applyRecommendation->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function render()
    {
        return view("Recommendation::livewire.apply-recommendation.bill");
    }
}
