<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Districts\Models\District;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\Enums\ApplicantTypeEnum;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\BuildingStructureEnum;
use Src\Ebps\Enums\DocumentTypeEnum;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Enums\MapProcessTypeEnum;
use Src\Ebps\Enums\OwnershipTypeEnum;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Models\HouseOwnerDetail;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Service\CustomerLandDetailService;
use Src\Ebps\Service\FourBoundaryAdminService;
use Src\Ebps\Service\HouseOwnerDetailService;
use Src\Ebps\Service\MapApplyAdminService;
use App\Facades\ImageServiceFacade;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Models\Document;
use Src\Ebps\Models\DocumentFile;
use Illuminate\Support\Facades\DB;
use Src\LocalBodies\Models\LocalBody;
use Src\Settings\Models\FiscalYear;
use Livewire\Attributes\On;

class ChangeOwnerForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?Action $action;
    public ?CustomerLandDetail $customerLandDetail;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public $constructionTypes;
    public $landDetails = [];
    public $isSameCustomer = false;
    public $landOwnerPhoto;
    public $uploadedFiles = [];
    public $customer_id;
    public bool $openModal = false;
    public bool $isModalForm = true;
    public bool $addLandForm = false;
    public $issuedDistricts= [];
    public $houseOwnerProvinces = [];
    public $houseOwnerDistricts = [];
    public $houseOwnerLocalBodies = [];
    public $houseOwnerWards = [];
    public $houseOwnerPhoto;
    public $mapDocuments = [];
   

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
            'houseOwnerDetail.reason_of_owner_change' => ['nullable'],
        ];

        return $rules;
    }

   
    public function render(){
        return view("Ebps::livewire.change-owner");
    }

 

    public function getHouseOwnerDistricts(): void
    {
        $this->houseOwnerDistricts = getDistricts($this->houseOwnerDetail['province_id'])->pluck('title', 'id')->toArray();
     
        $this->houseOwnerLocalBodies = [];
        $this->houseOwnerWards = [];
    }

    public function getHouseOwnerLocalBodies(): void
    {
        $this->houseOwnerLocalBodies = getLocalBodies($this->houseOwnerDetail['district_id'])->pluck('title', 'id')->toArray();
        $this->houseOwnerWards = [];
    }

    public function getHouseOwnerWards(): void
    {
        $houseOwnerLocalBody = LocalBody::find($this->houseOwnerDetail['local_body_id']);
        $this->houseOwnerWards = $houseOwnerLocalBody ? getWards($houseOwnerLocalBody->wards) : [];
    }
   
   
    public function loadWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->customerLandDetail->local_body_id)->wards);
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

    public function mount(MapApply $mapApply, CustomerLandDetail $customerLandDetail, HouseOwnerDetail $houseOwnerDetail)
    {
        
        $this->customerLandDetail = $customerLandDetail;
        $this->mapApply = $mapApply->load('landDetail', 'customer', 'houseOwner.parent');
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->get();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->applicantProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->landOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->houseOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->localBodies = getLocalBodies(district_ids: key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
          
        $this->issuedDistricts = District::whereNull('deleted_at')->get();
        $this->mapDocuments = $this->mapDocuments ?? [];

        $this->wards = [];
        $this->buildingStructures = BuildingStructureEnum::cases();
        $this->mapProcessTypes = MapProcessTypeEnum::cases();
        $this->applicantTypes = ApplicantTypeEnum::cases();
        $this->ownerships = LandOwernshipEnum::cases();
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
            $this->houseOwnerDetail->district_id = $customer->kyc->permanent_district_id;
            $this->houseOwnerDetail->local_body_id = $customer->kyc->permanent_local_body_id;
            $this->houseOwnerDetail->ward_no = $customer->kyc->permanent_ward;
            $this->houseOwnerDetail->tole = $customer->kyc->permanent_tole;
            $this->getHouseOwnerDistricts();
            $this->getHouseOwnerLocalBodies();
            $this->getHouseOwnerWards();          

        }else{
           
            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }

    }

    public function save()
    {   
        $this->validate();

        if($this->mapApply->houseOwner)
        {
            $parent = $this->mapApply->houseOwner->id;
        }

        $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);

        $dto = MapApplyAdminDto::fromLiveWireModel($this->mapApply);
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $this->houseOwnerDetail->parent_id = $parent ? $parent : null;
        $this->houseOwnerDetail->status = 'pending';
        $houseOwnerDto = HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail);

        $service = new MapApplyAdminService();
        $ownerDetail = new HouseOwnerDetailService();
        

        DB::beginTransaction();
        try{
       
            $houseOwner = $ownerDetail->store( $houseOwnerDto);
            // $this->mapApply->house_owner_id = $houseOwner->id;

            // $mapApply = $service->update($this->mapApply,$dto);
            // $this->storeDocumentFiles( $mapApply->id, $this->uploadedFiles, $this->mapDocuments, $houseOwner->id);
            DB::commit();
            $this->successFlash(__('ebps::ebps.application_updated_successfully'));
            return redirect()->route('admin.ebps.map_applies.show-template', ['houseOwnerId' => $houseOwner->id]);
           
        }  catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
        }

    }

    // private function storeDocumentFiles(int $mapApplyId, array $files, $mapDocuments, int $houseOwnerId): void
    // {
    //     foreach ($files as $index => $file) {
    //         if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    //             $storedFilePath = $this->processFiles($file);
    //             DocumentFile::create([
    //                 'map_apply_id' => $mapApplyId,
    //                 'title' => $mapDocuments[$index]->title,
    //                 'file' => $storedFilePath,
    //                 'document_type' => DocumentTypeEnum::HOUSE_OWNER_CHANGE->value,
    //                 'house_owner_id' => $houseOwnerId,
    //             ]);

    //         }
    //     }
    // }

   
    private function processFiles($file)
    {
        if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        {
           return ImageServiceFacade::compressAndStoreImage($file,  config('src.Ebps.ebps.path'));
        }

        return $file;
    }

}
