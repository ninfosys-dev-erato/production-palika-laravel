<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\GrantManagement\Controllers\CashGrantAdminController;
use Src\GrantManagement\DTO\CashGrantAdminDto;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Models\HelplessnessType;
use Src\GrantManagement\Service\CashGrantAdminService;
use Src\Wards\Models\Ward;
use App\Facades\ImageServiceFacade;
use Src\Customers\Models\Customer;
use Carbon\Carbon;

class CashGrantForm extends Component
{
    use SessionFlash, WithFileUploads;
    public $customer = [];

    public ?CashGrant $cashGrant;
    public ?Action $action;
    public $helplessnessTypes = [];
    public $wards = [];
    public $uploadedFile;
    public $uploadedFileUrl;
    public $name;

    public function rules(): array
    {
        return [
            'cashGrant.name' => ['required'],
            'cashGrant.address' => ['required'], // ward no
            'cashGrant.age' => ['required'],
            'cashGrant.contact' => ['required'],
            'cashGrant.citizenship_no' => ['required'],
            'cashGrant.father_name' => ['required'],
            'cashGrant.grandfather_name' => ['required'],
            'cashGrant.helplessness_type_id' => ['required'],
            'cashGrant.cash' => ['required'],
            'cashGrant.file' => ['nullable'],
            'cashGrant.remark' => ['required'],
            'uploadedFile' => ['nullable']

        ];
    }
    public function messages(): array
    {
        return [
            'cashGrant.name.required' => __('grantmanagement::grantmanagement.name_is_required'),
            'cashGrant.address.required' => __('grantmanagement::grantmanagement.address_is_required'),
            'cashGrant.age.required' => __('grantmanagement::grantmanagement.age_is_required'),
            'cashGrant.contact.required' => __('grantmanagement::grantmanagement.contact_is_required'),
            'cashGrant.citizenship_no.required' => __('grantmanagement::grantmanagement.citizenship_no_is_required'),
            'cashGrant.father_name.required' => __('grantmanagement::grantmanagement.father_name_is_required'),
            'cashGrant.grandfather_name.required' => __('grantmanagement::grantmanagement.grandfather_name_is_required'),
            'cashGrant.helplessness_type_id.required' => __('grantmanagement::grantmanagement.helplessness_type_id_is_required'),
            'cashGrant.cash.required' => __('grantmanagement::grantmanagement.cash_is_required'),
            'cashGrant.remark.required' => __('grantmanagement::grantmanagement.remark_is_required'),
            'uploadedFile.required' => __('grantmanagement::grantmanagement.uploadedfile_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.cash-grants-form");
    }

    public function mount(CashGrant $cashGrant, Action $action)
    {
        $this->cashGrant = $cashGrant;
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_ne', 'id')->toArray();
        $this->customer = Customer::whereNotNull('kyc_verified_at')
            ->pluck('name', 'id');


        // $this->wards = getWards()->pluck(app()->getLocale() === 'en' ? 'title_en' : 'title', 'id')->toArray();
        // $this->helplessnessTypes = HelplessnessType::all();
        $this->helplessnessTypes = HelplessnessType::whereNull('deleted_at')->pluck('helplessness_type', 'id')->toArray();

        $this->action = $action;

        if ($action == Action::UPDATE) {
            $this->handleFileUpload(null, 'file', 'uploadedFileUrl');
            $this->name = $this->cashGrant->name;
        }
    }

    public function showUserData($id)
    {
        $customer = Customer::whereNotNull('kyc_verified_at')
            ->with([
                'kyc.permanentProvince',
                'kyc.permanentDistrict',
                'kyc.permanentLocalBody'
            ])
            ->find($id);


        if (!$customer || !$customer->kyc) {
            return;
        }

        if ($customer->kyc->status->value === 'accepted') {

            $this->cashGrant->contact = $customer->mobile_no ?? '';
            $this->cashGrant->father_name = $customer->kyc->father_name ?? '';
            $this->cashGrant->grandfather_name = $customer->kyc->grandfather_name ?? '';
            $dob = $customer->kyc->english_date_of_birth;

            $calcAge = $dob
                ? Carbon::parse($dob)->age
                : null;

            $this->cashGrant->age = $calcAge === 0 ? "" : $calcAge;
        }

        // $this->cashGrant->address = $kyc->permanent_district_id ?? '';

        // $this->farmer->local_body_id = $kyc->permanent_local_body_id ?? '';

        // $this->farmer->ward_no = $kyc->permanent_ward ?? '';
        // $this->farmer->tole = $kyc->permanent_tole ?? '';
        // $this->farmer->village = $kyc->temporary_tole ?? '';
        // $this->farmer->grandfather_name = $kyc->grandfather_name ?? '';
        // $this->farmer->father_name = $kyc->father_name ?? '';

    }
    public function updatedUploadedFile()
    {
        $this->handleFileUpload($this->uploadedFile, 'file', 'uploadedFileUrl');
    }
    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.GrantManagement.grant.file'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );

            $this->cashGrant->{$modelField} = $save;


            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.GrantManagement.grant.file'),
                filename: $save,
                disk: getStorageDisk('private')
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->cashGrant->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.GrantManagement.grant.file'),
                    filename: $this->cashGrant->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }

    public function save()
    {
        $this->validate();


        // if ($this->uploadedFile) {
        //     $this->cashGrant->file = FileFacade::saveFile($this->uploadedFile, config('src.GrantManagement.grant.file'));
        // }

        // if ($this->uploadedFile) {
        //     $this->cashGrant->file = FileFacade::saveFile(
        //         $this->uploadedFile,
        //         config('src.GrantManagement.grant.file'),
        //         disk: getStorageDisk('private'),
        //         filename: ""
        //     );
        // }

        // $this->cashGrant->file = FileFacade::saveFile(
        //     file: $this->uploadedFile,
        //     path: config('src.GrantManagement.grant.file'),
        //     disk: getStorageDisk('private'),
        //     filename: ""
        // );


        $dto = CashGrantAdminDto::fromLiveWireModel($this->cashGrant);
        $service = new CashGrantAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cash_grant_created_successfully'));
                return redirect()->route('admin.cash_grants.index');
                break;
            case Action::UPDATE:
                $service->update($this->cashGrant, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.cash_grant_updated_successfully'));
                return redirect()->route('admin.cash_grants.index');
                break;
            default:
                return redirect()->route('admin.cash_grants.index');
                break;
        }
    }
}
