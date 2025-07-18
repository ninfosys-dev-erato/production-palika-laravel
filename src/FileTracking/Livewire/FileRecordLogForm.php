<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FileTracking\Controllers\FileRecordLogAdminController;
use Src\FileTracking\DTO\FileRecordLogAdminDto;
use Src\FileTracking\Models\FileRecordLog;
use Src\FileTracking\Service\FileRecordLogAdminService;

class FileRecordLogForm extends Component
{
    use SessionFlash;

    public ?FileRecordLog $fileRecordLog;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fileRecordLog.reg_no' => ['required'],
    'fileRecordLog.status' => ['required'],
    'fileRecordLog.notes' => ['required'],
    'fileRecordLog.handler_type' => ['required'],
    'fileRecordLog.handler_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'fileRecordLog.reg_no.required' => __('filetracking::filetracking.reg_no_is_required'),
            'fileRecordLog.status.required' => __('filetracking::filetracking.status_is_required'),
            'fileRecordLog.notes.required' => __('filetracking::filetracking.notes_is_required'),
            'fileRecordLog.handler_type.required' => __('filetracking::filetracking.handler_type_is_required'),
            'fileRecordLog.handler_id.required' => __('filetracking::filetracking.handler_id_is_required'),
        ];
    }

    public function render(){
        return view("FileTracking::livewire.file-record-log-form");
    }

    public function mount(FileRecordLog $fileRecordLog,Action $action)
    {
        $this->fileRecordLog = $fileRecordLog;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = FileRecordLogAdminDto::fromLiveWireModel($this->fileRecordLog);
            $service = new FileRecordLogAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash( __('filetracking::filetracking.file_record_log_created_successfully'));
                    return redirect()->route('admin.file_record_logs.index');
                case Action::UPDATE:
                    $service->update($this->fileRecordLog,$dto);
                    $this->successFlash( __('filetracking::filetracking.file_record_log_updated_successfully'));
                    return redirect()->route('admin.file_record_logs.index');
                default:
                    return redirect()->route('admin.file_record_logs.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
