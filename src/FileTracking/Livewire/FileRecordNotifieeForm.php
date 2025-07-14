<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FileTracking\Controllers\FileRecordNotifieeAdminController;
use Src\FileTracking\DTO\FileRecordNotifieeAdminDto;
use Src\FileTracking\Models\FileRecordNotifiee;
use Src\FileTracking\Service\FileRecordNotifieeAdminService;

class FileRecordNotifieeForm extends Component
{
    use SessionFlash;

    public ?FileRecordNotifiee $fileRecordNotifiee;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fileRecordNotifiee.file_record_log_id' => ['required'],
    'fileRecordNotifiee.notifiable_type' => ['required'],
    'fileRecordNotifiee.notifiable_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'fileRecordNotifiee.file_record_log_id.required' => __('filetracking::filetracking.file_record_log_id_is_required'),
            'fileRecordNotifiee.notifiable_type.required' => __('filetracking::filetracking.notifiable_type_is_required'),
            'fileRecordNotifiee.notifiable_id.required' => __('filetracking::filetracking.notifiable_id_is_required'),
        ];
    }

    public function render(){
        return view("FileTracking::livewire.file-record-notifee-form");
    }

    public function mount(FileRecordNotifiee $fileRecordNotifiee,Action $action)
    {
        $this->fileRecordNotifiee = $fileRecordNotifiee;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = FileRecordNotifieeAdminDto::fromLiveWireModel($this->fileRecordNotifiee);
        $service = new FileRecordNotifieeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash( __('filetracking::filetracking.file_record_notifiee_created_successfully'));
                return redirect()->route('admin.file_record_notifiees.index');
                break;
            case Action::UPDATE:
                $service->update($this->fileRecordNotifiee,$dto);
                $this->successFlash( __('filetracking::filetracking.file_record_notifiee_updated_successfully'));
                return redirect()->route('admin.file_record_notifiees.index');
                break;
            default:
                return redirect()->route('admin.file_record_notifiees.index');
                break;
        }
    }
}
