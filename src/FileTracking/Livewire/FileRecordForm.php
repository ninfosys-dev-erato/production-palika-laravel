<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FileTracking\Controllers\FileRecordAdminController;
use Src\FileTracking\DTO\FileRecordAdminDto;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\FileRecordAdminService;

class FileRecordForm extends Component
{
    use SessionFlash;

    public $fileRecords;
    public $offset = 0;
    public $total = 0;
    public function rules(): array
    {
        return [
            'fileRecord.reg_no' => ['required'],
            'fileRecord.subject_type' => ['required'],
            'fileRecord.subject_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'fileRecord.reg_no.required' => __('filetracking::filetracking.reg_no_is_required'),
            'fileRecord.subject_type.required' => __('filetracking::filetracking.subject_type_is_required'),
            'fileRecord.subject_id.required' => __('filetracking::filetracking.subject_id_is_required'),
            'fileRecord.registration_date.required' => __('filetracking::filetracking.subject_id_is_required'),
            'fileRecord.sender_document_number.required' => __('filetracking::filetracking.subject_id_is_required'),
        ];
    }

    public function render()
    {
        return view("FileTracking::livewire.file-record-form");
    }

    public function mount()
    {
        $query = FileRecord::whereNull('deleted_at');
        $this->fileRecords = $query
            ->offset($this->offset)
            ->limit(50)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->total = $query->count();
    }

    public function save()
    {

        $this->validate();
        try {
            $dto = FileRecordAdminDto::fromLiveWireModel($this->fileRecord);

            $service = new FileRecordAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('filetracking::filetracking.file_record_created_successfully'));
                    return redirect()->route('admin.file_records.index');
                case Action::UPDATE:
                    $service->update($this->fileRecord, $dto);
                    $this->successFlash(__('filetracking::filetracking.file_record_updated_successfully'));
                    return redirect()->route('admin.file_records.index');
                default:
                    return redirect()->route('admin.file_records.index');
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
