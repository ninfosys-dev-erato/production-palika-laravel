<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Districts\Models\District;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\Enums\ApplicantTypeEnum;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\BuildingStructureEnum;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Enums\MapProcessTypeEnum;
use Src\Ebps\Enums\OwnershipTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Models\HouseOwnerDetail;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Service\HouseOwnerDetailService;
use Src\Ebps\Service\MapApplyAdminService;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Models\DocumentFile;
use Illuminate\Support\Facades\DB;
use Src\LocalBodies\Models\LocalBody;
use Src\Settings\Models\FiscalYear;
use Livewire\Attributes\On;

class OldMapApplicationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?Action $action;
    public ?CustomerLandDetail $customerLandDetail;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public $constructionTypes;

    public $uploadedImage;
    public $mapDocuments;
    public $uploadedFiles = [];
    public $customer_id;
    public bool $openModal = false;
    public bool $isModalForm = true;
    public bool $addLandForm = false;
    public $ownerships;
    public $provinces = [];
    public $districts = [];
    public $localBodies = [];
    public $wards = [];
    public $issuedDistricts= [];
    public $buildingStructures;
    public $mapProcessTypes;
    public $fiscalYears;
    public $usageOptions;
    public $houseOwnerPhoto;


    public function rules(): array
    {
        $rules = [
            'houseOwnerDetail.owner_name'  => ['required', 'string', 'max:255'],
            'houseOwnerDetail.mobile_no'  => ['required'],
            'houseOwnerDetail.father_name' => ['required', 'string', 'max:255'],
            'houseOwnerDetail.grandfather_name' => ['required', 'string', 'max:255'],
            'houseOwnerDetail.citizenship_no' => ['required'],
            'houseOwnerDetail.citizenship_issued_at' => ['required'],
            'houseOwnerDetail.citizenship_issued_date' => ['required'],
            'houseOwnerDetail.province_id' => ['required'],
            'houseOwnerDetail.district_id' => ['required'],
            'houseOwnerDetail.local_body_id' => ['required'],
            'houseOwnerDetail.ward_no' => ['required'],
            'mapApply.map_process_type' => ['required'],
            'mapApply.fiscal_year_id'   => ['required'],
            'mapApply.registration_date'=> ['required'],
            'mapApply.registration_no'  => ['required'],
            'mapApply.building_structure'  => ['required'],
            'mapApply.construction_type_id' => ['required'],
            'mapApply.usage'        => ['required'],
            'mapApply.full_name'    => ['nullable'],
            'mapApply.age'          => ['nullable'],
            'mapApply.applied_date' => ['required'],
            'uploadedImage'         => ['required'],
            'mapApply.is_applied_by_customer'=> ['nullable'],
        ];

        foreach ($this->uploadedFiles as $key => $file) {
            $rules["uploadedFiles.$key"] = 'max:1024'; // 1MB max
        }

        return $rules;
    }

    public function render(){
        return view("Ebps::livewire.old-application.old-application-form");
    }

    public function getDistricts(): void
    {
        $this->districts = getDistricts($this->houseOwnerDetail['province_id'])->pluck('title', 'id')->toArray();

        $this->localBodies = [];
        $this->wards = [];
    }

    public function getLocalBodies(): void
    {
        $this->localBodies = getLocalBodies($this->houseOwnerDetail['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards(): void
    {
        $localBody = LocalBody::find($this->houseOwnerDetail['local_body_id']);
        $this->wards = $localBody ? getWards($localBody->wards) : [];
    }


    public function mount(MapApply $mapApply,Action $action, CustomerLandDetail $customerLandDetail, HouseOwnerDetail $houseOwnerDetail)
    {
        $this->customerLandDetail = $customerLandDetail;
        $this->mapApply = $mapApply->load('landDetail', 'customer', 'houseOwner');

        $this->usageOptions = PurposeOfConstructionEnum::cases();
        $this->action = $action;
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->get();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->mapApply->submission_id = rand(1000000, 9999999);
        $this->constructionTypes = ConstructionType::whereNull('deleted_at')->get();

        $this->issuedDistricts = District::whereNull('deleted_at')->get();
        $this->ownerships = LandOwernshipEnum::cases();
        $this->wards = [];
        $this->mapDocuments = $this->mapDocuments ?? [];
        $this->uploadedFiles = $this->uploadedFiles ?? [];
        $this->buildingStructures = BuildingStructureEnum::cases();
        $this->mapProcessTypes = MapProcessTypeEnum::cases();

        if ($this->action === Action::UPDATE) {
            $this->customer_id = $this->mapApply->customer_id;
            $this->uploadedImage = $this->mapApply->signature;

            $storedDocuments = DocumentFile::where('map_apply_id', $this->mapApply->id)->get();

            foreach ($storedDocuments as $index => $document) {
                $this->uploadedFiles[$index] = $document->file;
                $this->mapDocuments[$index] = [
                    'title' => $document->title,
                ];
            }
            $this->houseOwnerDetail = $this->mapApply->houseOwner;
            $this->houseOwnerPhoto = $this->houseOwnerDetail->photo;
            if($this->houseOwnerDetail)
            {
                $this->getDistricts();
                $this->getLocalBodies();
                $this->getWards();
            }
        }
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        if($result['type'] === 'Customer')
        {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            $this->houseOwnerDetail->owner_name = $customer->name;
            $this->houseOwnerDetail->mobile_no = $customer->mobile_no;
            $this->houseOwnerDetail->father_name = $customer->kyc->father_name;
            $this->houseOwnerDetail->grandfather_name = $customer->kyc->grandfather_name;
            $this->houseOwnerDetail->citizenship_no = $customer->kyc->document_number;
            $this->houseOwnerDetail->citizenship_issued_date = $customer->kyc->document_issued_date_nepali;
            $this->houseOwnerDetail->citizenship_issued_at = $customer->kyc->document_issued_at;
            $this->houseOwnerDetail->province_id = $customer->kyc->permanent_province_id;
            $this->getDistricts();
            $this->houseOwnerDetail->district_id = $customer->kyc->permanent_district_id;
            $this->getLocalBodies();
            $this->houseOwnerDetail->local_body_id = $customer->kyc->permanent_local_body_id;
            $this->getWards();
            $this->houseOwnerDetail->ward_no = $customer->kyc->permanent_ward;
            $this->houseOwnerDetail->permanent_tole = $customer->kyc->permanent_tole;

        }else{

            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }

    }

    public function addDocument()
    {
        $this->mapDocuments[] = (object)[
            'title' => "",
        ];
    }

    public function removeDocuments($index)
    {
        unset($this->mapDocuments[$index]);
        unset($this->uploadedFiles[$index]);

        $this->mapDocuments = array_values($this->mapDocuments);
        $this->uploadedFiles = array_values($this->uploadedFiles);
    }

    public function save()
    {
        $this->prepareMapApplyData();
      

        $dto = MapApplyAdminDto::fromLiveWireModel($this->mapApply);
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $ownerDto = HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail);
        $service = new MapApplyAdminService();
        $ownerDetail = new HouseOwnerDetailService();

        DB::beginTransaction();
        try{
        switch ($this->action){
            case Action::CREATE:
                $houseOwner = $ownerDetail->store($ownerDto);
                $dto->house_owner_id = $houseOwner->id;
                $mapApply = $service->store($dto);
                $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments);
                DB::commit();
                $this->successFlash(__('ebps::ebps.application_created_successfully'));
                return redirect()->route('admin.ebps.old_applications.index');
                break;
            case Action::UPDATE:
                $mapApply = $service->update($this->mapApply,$dto);
                $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments);
                DB::commit();
                $this->successFlash(__('ebps::ebps.application_updated_successfully'));
                return redirect()->route('admin.ebps.old_applications.index');
                break;
            default:
                return redirect()->route('admin.ebps.old_applications.index');
                break;
        }
    }  catch (\Exception $e) {
        logger($e);
        DB::rollBack();
        $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
    }

    }

    private function prepareMapApplyData(): void
    {
        if (!$this->mapApply->submission_id) {
            $this->mapApply->submission_id = rand(1000000, 9999999);
        }

        $customer = Customer::where('mobile_no', $this->houseOwnerDetail->mobile_no)->first();
        if($customer){
            $this->mapApply->customer_id = $customer->id;
            $this->mapApply->full_name = $customer->name;
        }

        $this->mapApply->signature=  $this->uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ?
            $this->processFiles($this->uploadedImage)
                :
            $this->uploadedImage;

        $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);

        $this->mapApply->fiscal_year_id = FiscalYear::where('year', $this->mapApply->fiscal_year_id)
            ->value('id');
        
        $this->mapApply->application_type = ApplicationTypeEnum::OLD_APPLICATIONS->value;
        $this->mapApply->applicant_type = ApplicantTypeEnum::HOUSE_OWNER->value;
        $this->mapApply->full_name = $this->houseOwnerDetail->owner_name;
        $this->mapApply->mobile_no = $this->houseOwnerDetail->mobile_no;
        $this->mapApply->province_id = $this->houseOwnerDetail->province_id;
        $this->mapApply->district_id = $this->houseOwnerDetail->district_id;
        $this->mapApply->local_body_id = $this->houseOwnerDetail->local_body_id;
        $this->mapApply->ward_no = $this->houseOwnerDetail->ward_no;
    }

    private function storeDocumentFiles(int $mapApplyId, array $files, $mapDocuments): void
    {
        foreach ($files as $index => $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $storedFilePath = $this->processFiles($file);
                DocumentFile::create([
                    'map_apply_id' => $mapApplyId,
                    'title' => $mapDocuments[$index]->title,
                    'file' => $storedFilePath,
                ]);
            }
        }
    }

    private function processFiles($file)
    {
        if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        {
           return FileFacade::saveFile( config('src.Ebps.ebps.path'), "", $file, 'local');
        }else{
            return $file;
        }
    }

    public function messages(): array
    {
        return [
            'houseOwnerDetail.owner_name.required' => __('ebps::ebps.the_house_owner_name_field_is_required'),
            'houseOwnerDetail.owner_name.string' => __('ebps::ebps.the_house_owner_name_must_be_a_string'),
            'houseOwnerDetail.owner_name.max' => __('ebps::ebps.the_house_owner_name_may_not_be_greater_than_255_characters'),
            'houseOwnerDetail.mobile_no.required' => __('ebps::ebps.the_house_owner_mobile_number_is_required'),
            'houseOwnerDetail.father_name.required' => __('The father\'s name of the house owner is required.'),
            'houseOwnerDetail.father_name.string' => __('The father\'s name must be a string.'),
            'houseOwnerDetail.father_name.max' => __('The father\'s name may not be greater than 255 characters.'),
            'houseOwnerDetail.grandfather_name.required' => __('The grandfather\'s name of the house owner is required.'),
            'houseOwnerDetail.grandfather_name.string' => __('The grandfather\'s name must be a string.'),
            'houseOwnerDetail.grandfather_name.max' => __('The grandfather\'s name may not be greater than 255 characters.'),
            'houseOwnerDetail.citizenship_no.required' => __('ebps::ebps.the_citizenship_number_of_the_house_owner_is_required'),
            'houseOwnerDetail.citizenship_issued_at.required' => __('ebps::ebps.the_place_where_the_citizenship_was_issued_is_required'),
            'houseOwnerDetail.citizenship_issued_date.required' => __('ebps::ebps.the_date_when_the_citizenship_was_issued_is_required'),
            'houseOwnerDetail.province_id.required' => __('ebps::ebps.the_province_is_required'),
            'houseOwnerDetail.district_id.required' => __('ebps::ebps.the_district_is_required'),
            'houseOwnerDetail.local_body_id.required' => __('ebps::ebps.the_local_body_is_required'),
            'houseOwnerDetail.ward_no.required' => __('ebps::ebps.the_ward_number_is_required'),
            'mapApply.map_process_type.required' => __('ebps::ebps.the_map_process_type_is_required'),
            'mapApply.fiscal_year_id.required' => __('ebps::ebps.the_fiscal_year_is_required'),
            'mapApply.registration_date.required' => __('ebps::ebps.the_registration_date_is_required'),
            'mapApply.registration_no.required' => __('ebps::ebps.the_registration_number_is_required'),
            'mapApply.building_structure.required' => __('ebps::ebps.the_building_structure_is_required'),
            'mapApply.construction_type_id.required' => __('ebps::ebps.the_construction_type_is_required'),
            'mapApply.usage.required' => __('ebps::ebps.the_usage_type_is_required'),
            'mapApply.applied_date.required' => __('ebps::ebps.the_applied_date_is_required'),
            'uploadedImage.required' => __('ebps::ebps.the_uploaded_image_is_required'),
            '*.uploadedFiles.*.max' => __('ebps::ebps.each_uploaded_file_may_not_be_greater_than_1mb'),
        ];
    }


}
