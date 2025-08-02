<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\FileTrackingFacade;
use App\Facades\GlobalFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\FileTracking\Models\FileRecord;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class DartaForm extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public FileRecord $fileRecord;

    public $departments;
    public $farsuyat;
    public Action $action;
    public $applicant_id;
    public array $uploadedFiles;
    public bool $is_chalani = false;
    public bool $isCustomer = false;
    public $localBodies = [];
    public $wards = [];
    public $selectedDepartments = [];
    public $recepientDepartment;
    public $fiscalYears;

    public $hideDocumentType;
    public function rules(): array
    {
        $rules = [
            'fileRecord.reg_no' => ['nullable'],
            'fileRecord.title' => ['required'],
            'applicant_id' => ['nullable'],
            'uploadedFiles' => ['nullable'],
            'departments' => ['required'],
            'fileRecord.document_level' => ['nullable'],
            'fileRecord.registration_date' => ['nullable'],
            'fileRecord.received_date' => ['required'],
            'fileRecord.sender_document_number' => ['nullable'],
            'fileRecord.fiscal_year' => ['nullable'],

        ];
        if (!$this->isCustomer) {
            $rules['fileRecord.applicant_mobile_no'] = ['required'];
            $rules['fileRecord.applicant_address'] = ['required'];
            $rules['fileRecord.applicant_name'] = ['required'];
            $rules['fileRecord.local_body_id'] = ['nullable'];
            $rules['fileRecord.ward'] = ['nullable'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'fileRecord.title.required' => __('filetracking::filetracking.the_title_is_required'),
            'fileRecord.registration_date.required' => __('filetracking::filetracking.the_title_is_required'),
            'departments.required' => __('filetracking::filetracking.the_department_is_required'),
            'fileRecord.document_level.required' => __('filetracking::filetracking.the_document_level_is_required'),
            'fileRecord.applicant_mobile_no.required' => __('filetracking::filetracking.the_applicant_mobile_number_is_required'),
            'fileRecord.applicant_address.required' => __('filetracking::filetracking.the_applicant_address_is_required'),
            'fileRecord.applicant_name.required' => __('filetracking::filetracking.the_applicant_name_is_required'),
            'fileRecord.local_body_id.required' => __('filetracking::filetracking.the_local_body_id_is_required'),
            'fileRecord.ward.required' => __('filetracking::filetracking.the_ward_is_required'),
        ];
    }

    public function render()
    {
        return view("FileTracking::livewire.file-darta-form");
    }


    public function toggleCustomer()
    {
        $this->isCustomer = !$this->isCustomer;
        $this->dispatch('init-select2');
    }

    public function mount(FileRecord $fileRecord, Action $action)
    {
        $this->fileRecord = $fileRecord;

        $this->action = $action;
        $this->departments = Branch::whereNull('deleted_at')
            ->pluck('title', 'id')
            ->toArray();
        $wards = collect();
        $branches = collect();

        $user = auth()->user(); // or however you get the logged-in user

        if (GlobalFacade::ward() || $user->hasRole('superadmin')) {
            $this->fileRecord->document_level = 'ward';
            $wards = Ward::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(['id', 'ward_name_ne'])
                ->map(function ($ward) {
                    $ward->display_name = $ward->ward_name_ne;
                    return $ward;
                });
        }

        if (GlobalFacade::department() || $user->hasRole('superadmin')) {
            $this->fileRecord->document_level = 'palika';
            $branches = Branch::whereNull('deleted_at')
                ->whereNull('deleted_by')
                ->get(['id', 'title'])
                ->map(function ($branch) {
                    $branch->display_name = $branch->title;
                    return $branch;
                });
        }

        $this->recepientDepartment = $wards
            ->merge($branches)
            ->mapWithKeys(fn($item) => [
                get_class($item) . '_' . $item->id => $item->display_name
            ])
            ->toArray();
            

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');

        $user = auth()->user()->fresh();

        if ($user->hasAnyRole(['वडा सचिव', 'वडा अध्यक्ष', 'वडा सदस्य', 'वडा प्रशासकीय प्रमुख'])) {
            $this->hideDocumentType = true;
        }


        if ($this->action == Action::UPDATE) {
            $recipientClass = is_array($fileRecord->recipient_type) ? implode(',', $fileRecord->recipient_type) : (string) $fileRecord->recipient_type;
            $recipientId = is_array($fileRecord->recipient_id) ? implode(',', $fileRecord->recipient_id) : (string) $fileRecord->recipient_id;

            $this->selectedDepartments = $recipientClass . '_' . $recipientId;

            $this->farsuyat = (string) $fileRecord->farsyaut_type . '_' . (string) $fileRecord->farsyaut_id;
            $regDate = $this->fileRecord->registration_date;
            $year = intval(substr($regDate, 0, 4));

            if ($year >= 2070 && $year <= 2100) {

                $this->fileRecord->registration_date = replaceNumbers(substr($regDate, 0, 10), true);
            } else {
                try {
                    $bsDate = $this->adToBs(substr($regDate, 0, 10));
                    $this->fileRecord->registration_date = replaceNumbers($bsDate, true);
                } catch (\Exception $e) {
                    $this->fileRecord->registration_date = 'Invalid Date';
                }
            }
        } else {
            $this->fileRecord->fiscal_year = key(getSettingWithKey('fiscal-year'));
        }
    }

    public function openCustomerKycModal()
    {
        $this->showCustomerKycModal = true;
    }

    public function closeCustomerKycModal()
    {
        $this->showCustomerKycModal = false;
    }

    public function loadWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->fileRecord->local_body_id)->wards);
    }

    public function save()
    {
        $this->validate();

        $this->fileRecord->registration_date = $this->bsToAd($this->fileRecord['registration_date']); //converts nepali date to english
        $this->fileRecord->received_date = replaceNumbers($this->fileRecord['received_date']);

        if($this->farsuyat)
        {
            [$farsuyatType, $farsuyatId] = explode("_", $this->farsuyat);
            $this->fileRecord->farsyaut_id = $farsuyatId;
            $this->fileRecord->farsyaut_type = $farsuyatType;
        }
        if($this->selectedDepartments)
        {
            [$selectedDepartmentsType, $selectedDepartmentsId] = explode("_", $this->selectedDepartments);
            $this->fileRecord->recipient_type = $selectedDepartmentsType;
            $this->fileRecord->recipient_id = $selectedDepartmentsId;
        }
        try {
            $this->fileRecord->applicant_mobile_no =  $this->convertNepaliToEnglish($this->fileRecord->applicant_mobile_no);
            $storedDocuments = [];
            if ($this->uploadedFiles) {
                foreach ($this->uploadedFiles as $file) {
                    $path = FileFacade::saveFile(config('src.FileTracking.fileTracking.file'), '', $file, 'local');
                    $storedDocuments[] = $path;
                }
                $this->fileRecord->file = json_encode(value: $storedDocuments);
            }

            if ($this->hideDocumentType) {
                $this->fileRecord->document_level = 'ward';
            } else {
                $this->fileRecord->document_level = 'palika';
            }

            $this->fileRecord->is_chalani = $this->is_chalani;

            $this->fileRecord->departments = json_encode(GlobalFacade::localBody());
            $this->fileRecord->local_body_id = GlobalFacade::localBody();

            $this->fileRecord->ward = GlobalFacade::ward() ?? null;


            if ($this->isCustomer === true) {
                $applicant = Customer::where('id', $this->applicant_id)->with('kyc')->first();
                $this->fileRecord->applicant_name = $applicant->name;
                $this->fileRecord->applicant_mobile_no = $applicant->mobile_no;
                $this->fileRecord->ward = GlobalFacade::ward() ?? null;
                $this->fileRecord->local_body_id = $applicant->kyc->permanent_local_body_id;
            }
            FileTrackingFacade::recordFile(model: $this->fileRecord, action: $this->action);
            $this->successFlash(__('filetracking::filetracking.file_record_created_successfully'));
            return redirect()->route('admin.register_files.index');
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(((__('Something went wrong while saving.') . $e->getMessage())));
        }
    }
}
