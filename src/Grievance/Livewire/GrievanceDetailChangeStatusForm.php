<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Grievance\DTO\GrievanceDetailAdminDto;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceAssignHistory;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceInvestigationType;
use Src\Grievance\Service\GrievanceService;

class GrievanceDetailChangeStatusForm extends Component
{
    use SessionFlash;
    use WithFileUploads;

    public ?array $investigationTypes = [];
    public ?array $selectedInvestigationTypes= [];
    public ?GrievanceDetail $grievanceDetail;
    public ?GrievanceAssignHistory $grievanceAssignHistory;
    public Action $action;
    public ?string $suggestions = null;
    public ?array $documents = [];
    public $uploadedImage;

    public function rules(): array
    {
        $rules = [
            'grievanceDetail.status' => ['required', Rule::in(array_column(GrievanceStatusEnum::cases(), 'value'))],
            'selectedInvestigationTypes' => ['nullable', 'array'],
            'grievanceDetail.suggestions' => ['nullable', 'string'],
            'uploadedImage.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'],
        ];


        return $rules;
    }
    public function messages(): array
    {
        return [
            'grievanceDetail.status.required' => __('grievance::grievance.status_is_required'),
            'grievanceDetail.status.Rule::in(array_column(GrievanceStatusEnum::cases()' => __('grievance::grievance.status_has_invalid_validation_rule'),
            'grievanceDetail.status.value' => __('grievance::grievance.status_has_invalid_validation_value'),
            'selectedInvestigationTypes.nullable' => __('grievance::grievance.selectedinvestigationtypes_is_optional'),
            'selectedInvestigationTypes.array' => __('grievance::grievance.selectedinvestigationtypes_must_be_an_array'),
            'grievanceDetail.suggestions.nullable' => __('grievance::grievance.suggestions_is_optional'),
            'grievanceDetail.suggestions.string' => __('grievance::grievance.suggestions_must_be_a_string'),
            'uploadedImage.*.nullable' => __('* is optional'),
            'uploadedImage.*.file' => __('* has invalid validation: file'),
            'uploadedImage.*.mimes:pdf' => __('* has invalid validation: mimes'),
            'uploadedImage.*.doc' => __('* has invalid validation: doc'),
            'uploadedImage.*.docx' => __('* has invalid validation: docx'),
            'uploadedImage.*.jpg' => __('* has invalid validation: jpg'),
            'uploadedImage.*.jpeg' => __('* has invalid validation: jpeg'),
            'uploadedImage.*.png' => __('* has invalid validation: png'),
            'uploadedImage.*.max:2048' => __('* must not exceed max characters'),
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceDetail.changeStatus");
    }

    public function setKycStatus(string $status)
    {
        $this->grievanceDetail->status = $status;

        if ($status === 'closed') {
            $this->selectedInvestigationTypes = [];
        }
    }

    public function mount(GrievanceDetail $grievanceDetail): void
    {
        $this->grievanceDetail = $grievanceDetail;
        $this->action = Action::UPDATE;
        $title = $this->getTitle();
        $this->investigationTypes = GrievanceInvestigationType::select($title, 'id')->get()->toArray();
        if ($this->grievanceDetail->status->value === 'investigating') {
            $this->selectedInvestigationTypes = $this->grievanceDetail->investigationTypes?->pluck('id')->toArray() ?? [];
        }       
    }

    public function save()
    {
        $this->validate();
        try{
            $storedDocuments = $this->uploadedImage ? $this->processFiles($this->uploadedImage) : [];

            $this->grievanceDetail->documents = $storedDocuments;
            $dto = GrievanceDetailAdminDto::fromLiveWireModel($this->grievanceDetail, $this->documents);
            $this->grievanceDetail->status = $dto->status->value;
            $originalGrievanceDetail = GrievanceDetail::find($this->grievanceDetail->id);
            $oldStatus = $originalGrievanceDetail->status;

            $updateData = [
                'status' => $dto->status,
                'suggestions' => $dto->suggestions,
                'documents' => json_encode($dto->documents),
            ];
        
            $service = new GrievanceService();
            switch ($this->action) {
                case Action::UPDATE:
                    $service->updateStatus($this->grievanceDetail, $dto, $oldStatus, $updateData);
                    if ($dto->status->value === 'investigating') 
                    {
                        $this->grievanceDetail->investigationTypes()->sync($this->selectedInvestigationTypes);
                    }
                break;
            }

            $this->successFlash(__('grievance::grievance.grievance_detail_updated_successfully'));
            return redirect()->route('admin.grievance.grievanceDetail.show', $this->grievanceDetail->id);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function getTitle()
    {
        $lang = getAppLanguage();
        return $lang === 'en' ? 'title_en' : 'title';
    }

    private function processFiles(array|string $files): array
    {
        $storedFiles = [];
        foreach ($files as $file) {
            $storedFiles[] = $this->storeFile($file);
        }
        return $storedFiles;
    }

    private function storeFile($file): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
            return ImageServiceFacade::compressAndStoreImage($file, config('src.Grievance.grievance.document_path'), getStorageDisk('public'));
        }

        return FileFacade::saveFile(
            path: config('src.Grievance.grievance.document_path'),
            filename: null,
            file: $file,
            disk: getStorageDisk('private')
        );
    }
}