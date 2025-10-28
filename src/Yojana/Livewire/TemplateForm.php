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
use Src\Employees\Models\Employee;
use Src\Yojana\DTO\FormSigneeNameDto;
use Src\Yojana\Models\FormSigneeName;
use Src\Yojana\Service\FormSigneeAdminService;
use Src\Yojana\Traits\YojanaTemplate;

class TemplateForm extends Component
{

    use SessionFlash, WithFileUploads, YojanaTemplate;

    public bool $preview = true;
    public $letter;
    public $templateLetter;
    public $model;
    public $plan;
    public $letterType;
    public $model_id;

    public $employees;

    public $placeholders = [];
    public $showDynamicField = false;
    public $editorMode = 'preview';

    public function mount(WorkOrder|ConsumerCommittee $model, $letterType = null, $model_id = null)
    {
        $this->model_id = $model_id;
        $this->model = $model;
        $this->letterType = $letterType;

        $this->employees = Employee::whereNull('deleted_at')->pluck('name', 'id');

        if ($this->model->dynamic_data) {
            $this->placeholders = json_decode($this->model->dynamic_data, true);
        }

        if ($model instanceof WorkOrder) {
            $this->plan = Plan::find($this->model->plan_id);
            $this->templateLetter  = $model->letter_body;
        } elseif ($model instanceof ConsumerCommittee) {
            $this->templateLetter  = $model->{$letterType};
        }
        $this->letter = $this->renderDynamicInputs($this->templateLetter);
    }

    public function renderDynamicInputs($letter)
    {
        $html = $letter;

        preg_match_all('/@([a-zA-Z0-9_]+)-([a-zA-Z0-9_]+(?:-[a-zA-Z0-9_]+)*)@/', $letter, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $type = $match[1];
            $name = $match[2];
            $storedValue = $this->placeholders[$name] ?? '';

            if ($this->showDynamicField) {
                switch ($type) {
                    case 'select':
                        $replacement = '<select wire:model.defer="placeholders.' . $name . '" 
                                    class="form-select d-inline-block mb-1" 
                                    style="min-width:200px; width:25%;">
                                    <option value="">-- Select --</option>';
                        foreach ($this->employees as $id => $employeeName) {
                            $selected = $storedValue == $employeeName ? 'selected' : '';
                            $replacement .= '<option value="' . e($employeeName) . '" ' . $selected . '>' . e($employeeName) . '</option>';
                        }

                        $replacement .= '</select>';
                        break;

                    case 'input':
                        $replacement = '<input type="text"
                                       wire:model.defer="placeholders.' . $name . '"
                                       value="' . e($storedValue) . '"
                                       class="form-control d-inline-block mb-1"
                                       style="min-width:200px; width:25%;">';
                        break;
                    case 'inputnepalidate':
                        $replacement = '<input type="text"
                                       wire:model.defer="placeholders.' . $name . '"
                                       value="' . e($storedValue) . '"
                                       class="form-control d-inline-block mb-1 nepali-date"
                                       style="min-width:200px; width:25%;">';
                        $this->dispatch('init-registration-date');
                        break;
                    default:

                        break;
                }
            } else {

                $replacement = '<span>' . e($storedValue) . '</span>';
            }

            $html = str_replace($match[0], $replacement, $html);
        }

        return $html;
    }
    public function toggleDynamicData()
    {
        $this->showDynamicField = !$this->showDynamicField;
        $this->letter = $this->renderDynamicInputs($this->templateLetter);
    }


    public function saveDynamicData()
    {

        $this->model->update([
            'dynamic_data' => json_encode($this->placeholders)
        ]);


        $this->successToast(__('yojana::yojana.data_saved_successfully'));
    }


    public function deleteDynamicData()
    {

        $this->placeholders = [];


        $this->model->update(['dynamic_data' => null]);


        $this->letter = $this->renderDynamicInputs($this->templateLetter);


        $this->showDynamicField = true;


        $this->successToast(__('yojana::yojana.data_deleted_successfully'));
    }

    public function setEditorMode($mode)
    {
        $this->editorMode = $mode;

        switch ($mode) {
            case 'input':
                $this->showDynamicField = true;   // show input fields
                $this->preview = true;            // also show the rendered preview container
                $this->letter = $this->renderDynamicInputs($this->templateLetter);
                break;

            case 'preview':
                $this->showDynamicField = false;  // hide input fields
                $this->preview = true;            // show the rendered preview container
                $this->letter = $this->renderDynamicInputs($this->templateLetter);
                $this->saveDynamicData();
                break;

            case 'ck':
            default:
                $this->showDynamicField = false;  // hide input fields
                $this->preview = false;           // hide rendered preview, show CKEditor only
                break;
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

            $letterBody = $this->resolveTemplate($this->plan, $letterSample) ?? "";
            $this->letter = $letterSample?->styles . $letterBody;
            // }

        } elseif ($this->model instanceof ConsumerCommittee) {
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
