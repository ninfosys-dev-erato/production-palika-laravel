<?php

namespace Src\Yojana\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Exports\WorkOrdersExport;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\WorkOrder;
use Src\Yojana\Service\AdvancePaymentAdminService;
use Src\Yojana\Service\ImplementationAgencyAdminService;
use Src\Yojana\Service\PaymentAdminService;
use Src\Yojana\Service\WorkOrderAdminService;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Yojana\Service\TemplateAdminService;
use Livewire\Attributes\On;
use Src\Yojana\Traits\YojanaTemplate;

class TemplateForm extends Component
{

    use SessionFlash, WithFileUploads, YojanaTemplate;

    public bool $preview = true;
    public $letter;
    public $model;
    public $plan;
    public $letterType;
    public $model_id;

    public function mount(WorkOrder|ConsumerCommittee $model, $letterType = null, $model_id = null)
    {
        $this->model_id = $model_id;
        $this->model = $model;
        $this->letterType = $letterType;

        if ($model instanceof WorkOrder) {
            $this->plan = Plan::find($this->model->plan_id);
            $this->letter = $model->letter_body;
        }
        elseif ($model instanceof ConsumerCommittee) {
            $this->letter = $model->{$letterType};
        }

    }

    public function render()
    {
        return view("Yojana::livewire.template.template");
    }

    public function save()
    {
        if ($this->model instanceof WorkOrder) {
            $this->model->update([
                'letter_body' => $this->letter
            ]);
        } elseif ($this->model instanceof ConsumerCommittee) {
            $this->model->update([
                $this->letterType => $this->letter
            ]);
        }

        $this->successToast(__('yojana::yojana.saved_successfully'));
    }
    public function resetLetter()
    {
        // dd($this->model, $this->letter, $this->letterType);
        if ($this->model instanceof WorkOrder) {
            $this->model->load('letter_sample');
            $letterType = $this->model->letter_sample->letter_type;
            // if($letterType == LetterTypes::AdvancePayment){
            //     $advancePaymentService = new AdvancePaymentAdminService();
            //     $letter = $advancePaymentService->getWorkOrder($this->model_id);
            //     $this->letter = $letter->letter_body;
            // }elseif($letterType == LetterTypes::Agreement){
            //     $implementationAgencyService = new ImplementationAgencyAdminService();
            //     $letter = $implementationAgencyService->getWorkOrder($this->model_id);
            //     $this->letter = $letter->letter_body;
            // }elseif($letterType == LetterTypes::Payment){
            //     $paymentService = new PaymentAdminService();
            //     $letter = $paymentService->getWorkOrder($this->model_id);
            //     $this->letter = $letter->letter_body;
            // }
            // else
            // {
                $letterSample = LetterSample::where('id', $this->model->letter_sample_id)
                    ->where('implementation_method_id', $this->plan->implementation_method_id)
                    ->firstOrFail();

                $letterBody = $this->resolveTemplate($this->plan, $letterSample)??"";
                $this->letter = $letterSample?->styles.$letterBody;
            // }

        }
        elseif ($this->model instanceof ConsumerCommittee)

        {
            $letterSample = LetterSample::where('letter_type', $this->letterType)
                ->firstOrFail();
                $letterBody = $this->resolveTemplate($this->model, $letterSample) ?? "";
            $this->letter = $letterBody;
        }
        $this->save();
        $this->successToast(__('yojana::yojana.reset_successfully'));
        $this->dispatch('refresh-page');
    }

    public function togglePreview()
    {
        $this->preview = $this->preview ? false : true;
    }
    #[On('print-yojana-form')]
    public function print()
    {
        $service = new TemplateAdminService();
        $url = $service->getLetter($this->letter, $this->model);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }
}
