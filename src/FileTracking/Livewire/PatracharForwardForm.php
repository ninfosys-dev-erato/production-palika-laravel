<?php

namespace Src\FileTracking\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Src\Employees\Models\Branch;
use Src\FileTracking\DTO\FileRecordLogAdminDto;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\FileRecordLog;
use Src\FileTracking\Service\FileRecordLogAdminService;
use Src\FileTracking\Service\PatracharService;
use Src\Wards\Models\Ward;

class PatracharForwardForm extends Component
{
    use WithFileUploads,SessionFlash;
    public ?FileRecord $fileRecord;

    public ?FileRecordLog $fileRecordLog;
    public $receipents;

    protected $rules = [
        'receipent' => 'required',
        'fileRecordLog.notes'=>'nullable',
        'fileRecordLog.file'=>'nullable',
    ];
    #[Modelable]
    public $receipent;
    public function render(){
        return view('FileTracking::livewire.patrachar-forward-form');
    }

    public function mount(FileRecord $fileRecord , FileRecordLog $fileRecordLog)
    {
        $this->fileRecord = $fileRecord;
        $this->fileRecordLog = $fileRecordLog;
        $this->receipents = collect([
            ...Ward::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(),
            ...Branch::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(),
        ]);
    }

    #[On('patrachar-forward')]
    public function save()
    {
        $this->validate();
        $recipient = eval("return ". $this->receipent.';');
        $fileName = "";
        if ($this->fileRecordLog->file instanceof TemporaryUploadedFile) {
            $fileName = "log_{$this->fileRecord->id}_" . date('hismd') . "." . $this->fileRecordLog->file->getClientOriginalExtension();
            FileFacade::saveFile(
                path: config('src.FileTracking.fileTracking.file'),
                filename:$fileName,
                file:$this->fileRecordLog->file,
                disk: getStorageDisk('private'),
            );
        }
        $this->fileRecordLog->file = $fileName;
        $dto = FileRecordLogAdminDto::fromPatracharForward(
            fileRecord: $this->fileRecord,
            fileRecordLog: $this->fileRecordLog,
            recipient: $recipient,
        );
        $service = new FileRecordLogAdminService();
        $response =  $service->store($dto);
        //Forward to Recipient
        $patracharService = new PatracharService();
        $patracharService->forwardFile($this->fileRecord,collect([])->add($recipient));
        if($response){
            $this->successToast(__('filetracking::filetracking.file_forward_successful'));
        }else{
            $this->errorToast(__('filetracking::filetracking.file_forward_failed_try_again'));
        }
        $this->dispatch('partrachar-forward-complete');
    }

}
