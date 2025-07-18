<?php

namespace Src\Yojana\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDO;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\ProjectDocument;
use Illuminate\Support\Facades\Auth;


class DocumentUploadForm extends Component
{
    use SessionFlash, WithFileUploads;
    public $projectDocument;

    public Plan $plan;

    public $formation_minute;
    public $agreement_application;
    public $planning_recommendation;
    public $deposit_voucher;
    public $citizenship;
    public $rate_analysis;
    public $cost_estimation;
    public $attachments;
    public $photo_before_project;
    public $photo_plan_assessment;
    public $photo_completed_project;
    public $ward_payment_recommendation;
    public $technical_evaluation;
    public $monitoring_report;
    public $bill_attendance_form;
    public $construction_photos;
    public $work_completion_report;
    public $public_hearing_docs;
    public $other_documents;
    public $ward_recommendation;
    public $committee_decision;
    public $bill_lading_form;
    public $final_technical_evaluation;
    public $measuring_book;
    public $monitoring_committee_recommendation;
    public $expenses_publicized;
    public $inspection_report;
    public $committee_application;
    public $info_sheet_photos;

    public $formation_minute_Url;
    public $agreement_application_Url;
    public $planning_recommendation_Url;
    public $deposit_voucher_Url;
    public $citizenship_Url;
    public $rate_analysis_Url;
    public $cost_estimate_Url;
    public $attachments_Url;
    public $photo_before_project_Url;
    public $photo_plan_assessment_Url;
    public $photo_completed_project_Url;
    public $ward_payment_recommendation_Url;
    public $technical_evaluation_Url;
    public $monitoring_report_Url;
    public $bill_attendance_form_Url;
    public $construction_photos_Url;
    public $work_completion_report_Url;
    public $public_hearing_docs_Url;
    public $other_documents_Url;
    public $ward_recommendation_Url;
    public $ward_recommendation_payment_Url;
    public $committee_decision_Url;
    public $bill_lading_form_Url;
    public $final_technical_evaluation_Url;
    public $measuring_book_Url;
    public $monitoring_committee_recommendation_Url;
    public $expenses_publicized_Url;
    public $inspection_report_Url;
    public $committee_application_Url;
    public $info_sheet_photos_Url;
    public $cost_estimation_Url;

    public $fields = [
        'formation_minute',
        'agreement_application',
        'planning_recommendation',
        'deposit_voucher',
        'citizenship',
        'rate_analysis',
        'cost_estimation',
        'attachments',
        'photo_before_project',
        'photo_plan_assessment',
        'photo_completed_project',
        'ward_payment_recommendation',
        'technical_evaluation',
        'monitoring_report',
        'bill_attendance_form',
        'construction_photos',
        'work_completion_report',
        'public_hearing_docs',
        'other_documents',
        'ward_recommendation',
        'committee_decision',
        'bill_lading_form',
        'final_technical_evaluation',
        'measuring_book',
        'monitoring_committee_recommendation',
        'expenses_publicized',
        'inspection_report',
        'committee_application',
        'info_sheet_photos'
    ];


    protected $rules = [
        //        'plan_id' => 'required|integer|exists:pln_plans,id',
        // Add specific file validation if needed, e.g., max:2048
    ];
    public function mount(Plan $plan)
    {
        $this->plan = $plan;

        $this->projectDocument = ProjectDocument::whereNull('deleted_at')
            ->where('plan_id', $plan->id)
            ->get();
        foreach ($this->projectDocument as $document) {
            if (in_array($document->document_name, $this->fields)) {
                $this->{$document->document_name} = $document->data;
                $this->handleFileUpload(null, $document->document_name, $document->document_name . '_Url');
            }
        }
    }



    public function render()
    {
        return view('Yojana::livewire.cost-estimation.document-upload-form');
    }

    public function updated($propertyName)
    {
        // If the updated property matches one of the fields, handle the file upload
        if (in_array($propertyName, $this->fields)) {
            $this->handleFileUpload($this->{$propertyName}, $propertyName, $propertyName . '_Url');
        }
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {

        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.evaluation'),
                file: $file,
                disk: "local",
                filename: ""
            );
            ProjectDocument::updateOrCreate(
                [
                    'plan_id' => $this->plan->id,
                    'document_name' => $modelField,
                ],
                [
                    'data' => $save,
                    'deleted_at' => null,
                    'deleted_by' => null,
                ]
            );

            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.evaluation'),
                filename: $save,
                disk: 'local'
            );
            $this->successToast(__('yojana::yojana.data_saved_successfully'));
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.evaluation'),
                    filename: $this->{$modelField},
                    disk: 'local'
                );
            }
        }
    }
    public function deleteFile(string $modelField)
    {
        $document = ProjectDocument::where('plan_id', $this->plan->id)
            ->where('document_name', $modelField)
            ->first();
        if ($document) {
            $document->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::user()->id,
            ]);
            $this->{$modelField} = null;
            $this->{$modelField . '_Url'} = null;

            $this->successToast(__('yojana::yojana.file_deleted_successfully'));
        } else {
            $this->errorToast(__('yojana::yojana.file_not_found'));
        }
    }

    public function save() {}
}
