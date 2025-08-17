<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\FileTrackingFacade;
use App\Facades\GlobalFacade;
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
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class ChalaniForm extends Component
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
    public bool $is_chalani = true;
    public bool $isReceipent = true;
    public bool $isSignee = true;
    public bool $hideDocumentType = false;
    public $fiscalYears;
    public function rules(): array
    {
        return [
            'fileRecord.reg_no' => ['nullable'],
            'fileRecord.recipient_address' => ['nullable'],
            'fileRecord.fiscal_year' => ['required'],
            'fileRecord.title' => ['required'],
            'fileRecord.recipient_department' => ['nullable'],
            'fileRecord.recipient_name' => ['nullable'],
            'fileRecord.recipient_position' => ['nullable'],
            'fileRecord.signee_department' => ['required'],
            'fileRecord.signee_position' => ['nullable'],
            'fileRecord.signee_name' => ['nullable'],
            'applicant_id' => ['nullable'],
            'uploadedFiles' => ['nullable'],
            'fileRecord.document_level' => ['nullable'],
            'fileRecord.sender_medium' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'fileRecord.title.required' => __('filetracking::filetracking.the_title_is_required'),
            'fileRecord.fiscal_year.required' => __('filetracking::filetracking.fiscal_year_is_required'),
            'fileRecord.recipient_department.required' => __('filetracking::filetracking.the_recipient_department_is_required'),
            'fileRecord.recipient_name.required' => __('filetracking::filetracking.the_recipient_name_is_required'),
            'fileRecord.signee_department.required' => __('filetracking::filetracking.the_signee_department_is_required'),
            'fileRecord.signee_name.required' => __('filetracking::filetracking.the_signee_name_is_required'),
            'fileRecord.document_level.required' => __('filetracking::filetracking.the_document_level_is_required'),
            'fileRecord.sender_medium.required' => __('filetracking::filetracking.the_sender_medium_is_required'),
        ];
    }

    public function render()
    {
        return view("FileTracking::livewire.file-chalani-form");
    }
    public function mount(FileRecord $fileRecord, Action $action)
    {
        $this->fileRecord = $fileRecord;
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->action = $action;
        $user = auth()->user(); // Get the logged-in user

        $wards = collect();
        $branches = collect();

        if (GlobalFacade::ward() || $user->hasRole('superadmin')) {
            $wards = Ward::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get();
            $this->fileRecord->document_level = 'ward';
        }

        if (GlobalFacade::department() || $user->hasRole('superadmin')) {
            $branches = Branch::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get();

            $this->fileRecord->document_level = 'palika';
        }

        // Convert model collections to arrays with consistent structure
        $wardsArray = $wards->map(function ($ward) {
            return [
                'id' => 'Ward_' . $ward->id,
                'name' => $ward->ward_name_ne ?? $ward->ward_name_en,
                'type' => 'Ward',
                'model' => $ward
            ];
        });

        $branchesArray = $branches->map(function ($branch) {
            return [
                'id' => 'Branch_' . $branch->id,
                'name' => $branch->title,
                'type' => 'Branch',
                'model' => $branch
            ];
        });

        $this->recepientDepartment = $wardsArray->merge($branchesArray);
        $this->signeesDepartment = $wardsArray->merge($branchesArray);

        $user = auth()->user()->fresh();

        if ($user->hasAnyRole(['वडा सचिव', 'वडा अध्यक्ष', 'वडा सदस्य', 'वडा प्रशासकीय प्रमुख'])) {
            $this->hideDocumentType = true;
        }

        if ($this->action == Action::UPDATE) {
            $this->recipientDepartmentUser();
            $this->signeeDepartmentUser();
        } else {
            $this->fileRecord->fiscal_year = key(getSettingWithKey('fiscal-year'));
        }
    }

    public function recipientDepartmentUser()
    {
        $recipientDepartment = $this->fileRecord->recipient_department;

        if ($this->action == Action::CREATE) {
            [$recipientType, $recipientId] = explode('_', $recipientDepartment);

            if ($recipientType === "Branch") {
                $model = \Src\Employees\Models\Branch::find($recipientId);
                if ($model) {
                    $this->recipientDepartmentUsers = $model->users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                        ];
                    });
                }
            } else {
                $model = \Src\Wards\Models\Ward::find($recipientId);
                if ($model) {
                    $this->recipientDepartmentUsers = $model->users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                        ];
                    });
                }
            }
            return $this->recipientDepartmentUsers ?? collect();
        }
    }

    public function recipientUserPosition()
    {

        $employee = Employee::where('user_id', $this->fileRecord->recipient_name)->first();

        if ($employee) {
            $this->fileRecord->recipient_position =  $employee->designation?->title ?? 'No designation found';
        }
    }
    public function signeeDepartmentUser()
    {
        $signeeDepartment = $this->fileRecord->signee_department;
        if ($this->action == Action::CREATE) {
            [$signeeType, $signeeId] = explode('_', $signeeDepartment);

            if ($signeeType === "Branch") {
                $model = \Src\Employees\Models\Branch::find($signeeId);
                if ($model) {
                    $this->signeeDepartmentUsers = $model->users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                        ];
                    });
                }
            } else {
                $model = \Src\Wards\Models\Ward::find($signeeId);
                if ($model) {
                    $this->signeeDepartmentUsers = $model->users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                        ];
                    });
                }
            }

            return $this->signeeDepartmentUsers ?? collect();
        }
    }

    public function toggleReceipent()
    {
        $this->isReceipent = !$this->isReceipent;
    }
    public function toggleSignee()
    {
        $this->isSignee = !$this->isSignee;
    }
    public function signeeUserPosition()
    {
        $employee = Employee::where('user_id', $this->fileRecord->recipient_name)->first();

        if ($employee) {
            $this->fileRecord->signee_position =  $employee->designation?->title ?? 'No designation found';
        }
    }

    public function save()
    {
        $this->validate();
        try {
            if (!$this->isReceipent) {

                [$recipientType, $recipientId] = explode('_', $this->fileRecord->recipient_department);

                $this->fileRecord['recipient_type'] = $recipientType;
                $this->fileRecord['recipient_id']   = $recipientId;
                
                if ($recipientType === "Branch") {
                    $model = \Src\Employees\Models\Branch::find($recipientId);
                } else {
                    $model = \Src\Wards\Models\Ward::find($recipientId);
                }

                if ($model) {
                    $this->setDetails($model);
                }
            }

            $storedDocuments = [];
            if ($this->uploadedFiles) {
                foreach ($this->uploadedFiles as $file) {
                    $path = FileFacade::saveFile(config('src.FileTracking.fileTracking.file'), '', $file, getStorageDisk('private'));
                    $storedDocuments[] = $path;
                }
                $this->fileRecord->file = json_encode($storedDocuments);
            }


            $this->fileRecord->is_chalani = $this->is_chalani;

            $this->fileRecord->applicant_name = auth()->user()->fresh()->name;
            $this->fileRecord->applicant_mobile_no = auth()->user()->fresh()->mobile_no ?? 'N/A';
            if ($this->hideDocumentType) {
                $this->fileRecord->document_level = 'ward';
            }

            FileTrackingFacade::recordFile(model: $this->fileRecord, action: $this->action);
            $this->successFlash(__('filetracking::filetracking.chalani_created_successfully'));
            return redirect()->route('admin.chalani.index');
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(((__('Something went wrong while saving.') . $e->getMessage())));
        }
    }

    private function setDetails($model)
    {
        if ($model instanceof \Src\Wards\Models\Ward) {
            $this->fileRecord['recipient_department'] = $model->ward_name_ne;
            $this->fileRecord['signee_department'] = $model->ward_name_ne;
        } elseif ($model instanceof \Src\Employees\Models\Branch) {
            $this->fileRecord['recipient_department'] = $model->title;
            $this->fileRecord['signee_department'] = $model->title;
        }
    }
}
