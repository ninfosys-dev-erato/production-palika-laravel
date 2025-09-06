<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\Yojana\Controllers\EvaluationAdminController;
use Src\Yojana\DTO\EvaluationAdminDto;
use Src\Yojana\DTO\EvaluationCostDetailAdminDto;
use Src\Yojana\Enums\Installments;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\CostEstimationDetail;
use Src\Yojana\Models\Evaluation;
use Src\Yojana\Service\EvaluationAdminService;
use App\Facades\FileFacade;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Src\Yojana\Service\EvaluationCostDetailAdminService;

class EvaluationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Evaluation $evaluation;
    public ?Action $action = Action::CREATE;
    public $plan;
    public $agreement_date;
    public $agreed_completion_date;
    public $implementationMethod;
    public $purpose;
    public $area;
    public $costEstimationDetails;
    public $costEstimationData = [];
    public $costTotal;
    public $advancePayment;
    public $installments;
    public $totalVatAmount;

    //document upload for
    public $wardRecommendationDocument;
    public $wardRecommendationDocumentUrl;
    public $technicalEvaluationDocument;
    public $technicalEvaluationDocumentUrl;
    public $committeeReport;
    public $committeeReportUrl;
    public $attendanceReport;
    public $attendanceReportUrl;
    public $constructionProgressPhoto;
    public $constructionProgressPhotoUrl;
    public $workCompletionReport;
    public $workCompletionReportUrl;
    public $expenseReport;
    public $expenseReportUrl;
    public $otherDocument;
    public $otherDocumentUrl;

    public function rules(): array
    {
        $rules = [
            'evaluation.plan_id' => ['required'],
            'evaluation.evaluation_date' => ['required'],
            'evaluation.completion_date' => ['required'],
            'evaluation.installment_no' => ['required'],
            'evaluation.up_to_date_amount' => ['nullable'],
            'evaluation.assessment_amount' => ['nullable'],
            'evaluation.is_implemented' => ['nullable'],
            'evaluation.is_budget_utilized' => ['nullable'],
            'evaluation.is_quality_maintained' => ['nullable'],
            'evaluation.is_reached' => ['nullable'],
            'evaluation.is_tested' => ['nullable'],
            'evaluation.evaluation_amount' => ['nullable'],
            'evaluation.total_vat' => ['nullable'],
            'evaluation.testing_date' => ['nullable'],
            'evaluation.attendance_number' => ['nullable'],
            'evaluation.evaluation_no' => ['nullable'],
            'evaluation.ward_recommendation_document' => ['nullable'],
            'evaluation.technical_evaluation_document' => ['nullable'],
            'evaluation.committee_report' => ['nullable'],
            'evaluation.attendance_report' => ['nullable'],
            'evaluation.construction_progress_photo' => ['nullable'],
            'evaluation.work_completion_report' => ['nullable'],
            'evaluation.expense_report' => ['nullable'],
            'evaluation.other_document' => ['nullable'],
        ];

        // Add validation for cost estimation data
        if (!empty($this->costEstimationData)) {
            foreach ($this->costEstimationData as $index => $data) {
                $rules["costEstimationData.{$index}.up_to_date_amount"] = ['required', 'numeric', 'gt:0'];
            }
        }

        return $rules;
    }
    public function messages(): array
    {
        $messages = [
            'evaluation.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
            'evaluation.evaluation_date.required' => __('yojana::yojana.evaluation_date_is_required'),
            'evaluation.completion_date.required' => __('yojana::yojana.completion_date_is_required'),
            'evaluation.installment_no.required' => __('yojana::yojana.installment_no_is_required'),
            'evaluation.up_to_date_amount.nullable' => __('yojana::yojana.up_to_date_amount_is_optional'),
            'evaluation.assessment_amount.nullable' => __('yojana::yojana.assessment_amount_is_optional'),
            'evaluation.is_implemented.nullable' => __('yojana::yojana.is_implemented_is_optional'),
            'evaluation.is_budget_utilized.nullable' => __('yojana::yojana.is_budget_utilized_is_optional'),
            'evaluation.is_quality_maintained.nullable' => __('yojana::yojana.is_quality_maintained_is_optional'),
            'evaluation.is_reached.nullable' => __('yojana::yojana.is_reached_is_optional'),
            'evaluation.is_tested.nullable' => __('yojana::yojana.is_tested_is_optional'),
            'evaluation.evaluation_amount.required' => __('yojana::yojana.evaluation_amount_is_required'),
            'evaluation.testing_date.required' => __('yojana::yojana.testing_date_is_required'),
            'evaluation.attendance_number.required' => __('yojana::yojana.attendance_number_is_required'),
            'evaluation.evaluation_no.required' => __('yojana::yojana.evaluation_no_is_required'),
            'evaluation.ward_recommendation_document.nullable' => __('yojana::yojana.ward_recommendation_document_is_optional'),
            'evaluation.technical_evaluation_document.nullable' => __('yojana::yojana.technical_evaluation_document_is_optional'),
            'evaluation.committee_report.nullable' => __('yojana::yojana.committee_report_is_optional'),
            'evaluation.attendance_report.nullable' => __('yojana::yojana.attendance_report_is_optional'),
            'evaluation.construction_progress_photo.nullable' => __('yojana::yojana.construction_progress_photo_is_optional'),
            'evaluation.work_completion_report.nullable' => __('yojana::yojana.work_completion_report_is_optional'),
            'evaluation.expense_report.nullable' => __('yojana::yojana.expense_report_is_optional'),
            'evaluation.other_document.nullable' => __('yojana::yojana.other_document_is_optional'),
        ];

        // Add validation messages for cost estimation data
        if (!empty($this->costEstimationData)) {
            foreach ($this->costEstimationData as $index => $data) {
                $messages["costEstimationData.{$index}.up_to_date_amount.required"] = __('yojana::yojana.current_amount_required');
                $messages["costEstimationData.{$index}.up_to_date_amount.numeric"] = __('yojana::yojana.current_amount_must_be_numeric');
                $messages["costEstimationData.{$index}.up_to_date_amount.gt"] = __('yojana::yojana.current_amount_must_be_greater_than_zero');
            }
        }

        return $messages;
    }

    public function render()
    {
        return view("Yojana::livewire.evaluations.form");
    }

    public function mount(Evaluation $evaluation, Action $action, $plan = null)
    {
        $this->plan->load('agreement.agreementCost.agreementCostDetails.activity');
        $this->evaluation = $evaluation;
        $this->action = $action;
        $this->plan = $plan;
        $this->agreement_date = $this->plan?->agreement?->created_at
            ? $this->plan->agreement->created_at->format('Y-m-d')
            : "";
        $this->agreed_completion_date = $this->plan?->agreement?->plan_completion_date ?? "";
        $this->implementationMethod = $this->plan?->implementationMethod?->model->label() ?? "";
        $this->purpose = $this->plan?->purpose ?? "";
        $this->area = $this->plan?->planArea?->area_name ?? "";
        $this->evaluation->plan_id = $this->plan->id;
        $this->costEstimationDetails = $this->plan?->agreement;
        $this->costTotal = $this->plan?->costEstimation->value('total_cost');
        $this->advancePayment = $this->plan?->advancePayments?->sum('paid_amount') ?? 0;
        $this->installments = Installments::getForWeb();
        if ($action == Action::CREATE) {
            if ($this->plan?->agreement?->agreementCost?->agreementCostDetails) {
                foreach ($this->plan->agreement->agreementCost->agreementCostDetails as $index => $detail) {
                    $this->costEstimationData[$index] = [
//                        'activity' => $detail->activity->title ?? '-',
                        'activity_id' => $detail->activity_id ?? '-',
                        'unit' => $detail->unit ?? '-',
                        'agreement' => $detail->quantity,
                        'before_this' => 0,
                        'up_to_date_amount' => 0,
                        'current' => 0,
                        'rate' => $detail->contractor_rate,
                        'assessment_amount' => 0,
                        'is_vatable' => false,
                        'vat_amount' => 0,
                    ];
                }
            } else {
                $this->costEstimationData = [];
            }
        }
        if ($action == Action::UPDATE) {
            $this->handleFileUpload(null, 'ward_recommendation_document', 'wardRecommendationDocumentUrl');
            $this->handleFileUpload(null, 'technical_evaluation_document', 'technicalEvaluationDocumentUrl');
            $this->handleFileUpload(null, 'committee_report', 'committeeReportUrl');
            $this->handleFileUpload(null, 'attendance_report', 'attendanceReportUrl');
            $this->handleFileUpload(null, 'construction_progress_photo', 'constructionProgressPhotoUrl');
            $this->handleFileUpload(null, 'work_completion_report', 'workCompletionReportUrl');
            $this->handleFileUpload(null, 'expense_report', 'expenseReportUrl');
            $this->handleFileUpload(null, 'other_document', 'otherDocumentUrl');

            $this->evaluation?->load('costDetails.activity');
            foreach ($this->evaluation->costDetails as $index => $detail) {
                $this->costEstimationData[$index] = [
                    'activity' => $detail->activity->title ?? '-',
                    'activity_id' => $detail->activity->title ?? $detail->activity_id,
                    'unit' => $detail->unit,
                    'agreement' => $detail->agreement,
                    'before_this' => $detail->before_this,
                    'up_to_date_amount' => $detail->up_to_date_amount,
                    'current' => $detail->current,
                    'rate' => $detail->rate,
                    'assessment_amount' => $detail->assessment_amount,
                    'is_vatable' => $detail->vat_amount && $detail->vat_amount > 0,
                    'vat_amount' => $detail->vat_amount,
                ];
            }
        }
    }
    public function calculateAmount($index)
    {
        $rate = floatval($this->costEstimationData[$index]['rate'] ?? 0);
        $qty = floatval($this->costEstimationData[$index]['up_to_date_amount'] ?? 0);

        // Calculate assessment amount
        $assessment = $qty * $rate;
        $this->costEstimationData[$index]['assessment_amount'] = $assessment;

        // Calculate VAT if vatable
        if (!empty($this->costEstimationData[$index]['is_vatable'])) {
            $this->costEstimationData[$index]['vat_amount'] = $assessment * 0.13;
        } else {
            $this->costEstimationData[$index]['vat_amount'] = 0;
        }
        $this->evaluation->evaluation_amount = $this->finalAmount;
    }

    public function vatToggled($index)
    {
        $this->calculateAmount($index);
    }

    public function getTotalAssessmentProperty()
    {
        return collect($this->costEstimationData)->sum('assessment_amount');
    }

    public function getTotalVatProperty()
    {
        return collect($this->costEstimationData)->sum('vat_amount');
    }
    public function getFinalAmountProperty()
    {
        return ($this->totalAssessment + $this->totalVat);
    }



    public function save()
    {
        $this->evaluation->total_vat = $this->totalVat;
        $this->validate();
        try {
            $dto = EvaluationAdminDto::fromLiveWireModel($this->evaluation);
            $service = new EvaluationAdminService();
            $detailService = new EvaluationCostDetailAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    DB::beginTransaction();
                    $saved = $service->store($dto);
                    foreach ($this->costEstimationData as $detail) {
                        $detail['evaluation_id'] = $saved->id;
                        $detailDto = EvaluationCostDetailAdminDto::fromArrayData($detail);
                        $detailService->store($detailDto);
                    }
                    $this->action = Action::UPDATE;
                    DB::commit();
                    $this->successFlash(__('yojana::yojana.evaluation_created_successfully'));
                    $this->plan->status = PlanStatus::EvaluationCompleted;
                    $this->plan->save();
                    $this->dispatch('planStatusUpdate');
                    $this->dispatch('resetForm', 'open-evaluationTable');
                    $this->dispatch('open-evaluationTable');
                    break;
                case Action::UPDATE:
                    $updated = $service->update($this->evaluation, $dto);
                    $this->evaluation->costDetails()->delete();
                    foreach ($this->costEstimationData as $detail) {
                        $detail['evaluation_id'] = $updated->id;
                        $detailDto = EvaluationCostDetailAdminDto::fromArrayData($detail);
                        $detailService->store($detailDto);
                    }
                    $this->successFlash(__('yojana::yojana.evaluation_updated_successfully'));
                    $this->dispatch('resetForm', 'open-evaluationTable');
                    $this->dispatch('open-evaluationTable');
                    break;
                default:
                    // return redirect()->route('admin.evaluations.index');
                    break;
            }
        } catch (ValidationException $e) {
            DB::rollBack();
            //            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            DB::rollBack();
            //            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.evaluation'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );

            $this->evaluation->{$modelField} = $save;
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.evaluation'),
                filename: $save,
                disk: getStorageDisk('private')
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->evaluation->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.evaluation'),
                    filename: $this->evaluation->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }

    public function updatedWardRecommendationDocument()
    {
        $this->handleFileUpload($this->wardRecommendationDocument, 'ward_recommendation_document', 'wardRecommendationDocumentUrl');
    }
    public function updatedTechnicalEvaluationDocument()
    {
        $this->handleFileUpload($this->technicalEvaluationDocument, 'technical_evaluation_document', 'technicalEvaluationDocumentUrl');
    }
    public function updatedCommitteeReport()
    {
        $this->handleFileUpload($this->committeeReport, 'committee_report', 'committeeReportUrl');
    }

    public function updatedAttendanceReport()
    {
        $this->handleFileUpload($this->attendanceReport, 'attendance_report', 'attendanceReportUrl');
    }

    public function updatedConstructionProgressPhoto()
    {
        $this->handleFileUpload($this->constructionProgressPhoto, 'construction_progress_photo', 'constructionProgressPhotoUrl');
    }

    public function updatedWorkCompletionReport()
    {
        $this->handleFileUpload($this->workCompletionReport, 'work_completion_report', 'workCompletionReportUrl');
    }

    public function updatedExpenseReport()
    {
        $this->handleFileUpload($this->expenseReport, 'expense_report', 'expenseReportUrl');
    }

    public function updatedOtherDocument()
    {
        $this->handleFileUpload($this->otherDocument, 'other_document', 'otherDocumentUrl');
    }

    #[On('edit-evaluation')]
    public function editEvaluation($evaulationId)
    {
        $evaluation = Evaluation::findOrFail($evaulationId);

        $this->evaluation = $evaluation;
        $this->action = Action::UPDATE;

        // Load any dependent data if necessary
        $this->mount($evaluation, Action::UPDATE, $evaluation->plan);
        $this->dispatch('open-editEvaluation');
    }

    #[On('reset-form-evaluation')]
    public function resetForm()
    {
        $this->resetExcept(['plan', 'agreement_date', 'implementationMethod', 'purpose', 'area', 'costEstimationDetails', 'costTotal', 'advancePayment', 'plan_id']);
        //        dd($this->costEstimationDetails);
        $this->evaluation = new Evaluation();
        $this->evaluation->plan_id = $this->plan->id;
        $this->action = Action::CREATE;
    }
}
