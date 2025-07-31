<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\FileTrackingFacade;
use App\Facades\ImageServiceFacade;
use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Employee;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\PatracharService;
use Src\Wards\Models\Ward;

class FileRecordCompose extends Component
{
    use SessionFlash, WithFileUploads;

    public FileRecord $fileRecord;

    public $departments;
    public $signeesDepartment = [];
    public $recepientDepartment = [];
    public $recipientDepartmentUsers = [];
    public $signeeDepartmentUsers = [];
    public Action $action;
    public $applicant_id;
    public array $uploadedFiles;
    public bool $isReceipent = true;
    public array $selectedReceipents = [];

    public function rules(): array
    {
        return [
            'fileRecord.reg_no' => ['nullable'],
            'fileRecord.title' => ['required'],
            'fileRecord.body' => ['nullable'],
            'applicant_id' => ['nullable'],
            'uploadedFiles' => ['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'fileRecord.title.required' => __('filetracking::filetracking.the_title_is_required'),
            'fileRecord.recipient_department.required' => __('filetracking::filetracking.the_recipient_department_is_required'),
            'fileRecord.recipient_name.required' => __('filetracking::filetracking.the_recipient_name_is_required'),
            'fileRecord.document_level.required' => __('filetracking::filetracking.the_document_level_is_required'),
            'fileRecord.sender_medium.required' => __('filetracking::filetracking.the_sender_medium_is_required'),
        ];
    }

    public function render()
    {
        return view("FileTracking::livewire.compose");
    }
    public function mount(FileRecord $fileRecord)
    {
        $this->fileRecord = $fileRecord;

        $this->recepientDepartment = collect([
            ...Ward::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(['id', 'ward_name_ne']),
            ...Branch::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(['id', 'title']),
        ])->mapWithKeys(fn($item) => [
            get_class($item) . '_' . $item->id => $item->display_name
        ])->toArray();
    }

    public function recipientDepartmentUser()
    {
        $departmentId = $this->fileRecord->recipient_department;
        $this->recipientDepartmentUsers = Branch::find($departmentId)?->users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        return $this->recipientDepartmentUsers ?? collect();
    }

    public function recipientUserPosition()
    {

        $employee = Employee::where('user_id', $this->fileRecord->recipient_name)->first();

        if ($employee) {
            $this->fileRecord->recipient_position =  $employee->designation?->title ?? 'No designation found';

        }

    }

    public function toggleReceipent()
    {
        $this->isReceipent = !$this->isReceipent;

    }

    public function save()
    {
        $this->validate();
        $service = new PatracharService();
        try{
            $this->fileRecord['file'] = json_encode($this->storeUploadedFiles());
            $this->setApplicantDetails();
            $service->composeMessage($this->fileRecord,$this->selectedReceipents);
            $this->successFlash( __('filetracking::filetracking.composed_successfully'));
            return redirect()->route('admin.file_records.manage');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    private function setRecipientDetails($model)
    {
        if ($model instanceof \Src\Wards\Models\Ward) {
            $this->fileRecord['recipient_department'] = $model->address_ne;
            $this->fileRecord['recipient_name'] = $model->ward_name_ne;
        } elseif ($model instanceof \Src\Employees\Models\Branch) {
            $this->fileRecord['recipient_department'] = $model->title;
            $this->fileRecord['recipient_name'] = $model->title;
        }
    }
    private function storeUploadedFiles()
    {
        $storedDocuments = [];

        if ($this->uploadedFiles) {
            foreach ($this->uploadedFiles as $file) {
                // $path = ImageServiceFacade::compressAndStoreImage(
                //     $file,
                //     config('src.FileTracking.fileTracking.file'),
                //     'local'
                // );

                $path = FileFacade::saveFile( config('src.FileTracking.fileTracking.file'). '', $file, getStorageDisk('private'));
                $storedDocuments[] = $path;
            }
        }

        return $storedDocuments;
    }

    private function setApplicantDetails()
    {
        $this->fileRecord['applicant_name'] = auth()->user()->fresh()->name;
        $this->fileRecord['applicant_mobile_no'] = auth()->user()->fresh()->mobile_no ?? 'N/A';
    }

}

