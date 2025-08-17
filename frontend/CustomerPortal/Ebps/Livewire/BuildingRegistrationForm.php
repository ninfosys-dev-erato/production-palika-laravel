<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Districts\Models\District;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\DTO\OrganizationDetailDto;
use Src\Ebps\Enums\ApplicantTypeEnum;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\BuildingStructureEnum;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Enums\MapProcessTypeEnum;
use Src\Ebps\Enums\OwnershipTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Models\Document;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Models\HouseOwnerDetail;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\Organization;
use Src\Ebps\Models\OrganizationDetail;
use Src\Ebps\Service\CustomerLandDetailService;
use Src\Ebps\Service\FourBoundaryAdminService;
use Src\Ebps\Service\HouseOwnerDetailService;
use Src\Ebps\Service\MapApplyAdminService;
use App\Facades\ImageServiceFacade;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Models\CustomerLandDetail;
use Illuminate\Support\Facades\DB;
use Src\Ebps\Service\MapApplyDetailAdminService;
use Src\Ebps\Service\OrganizationDetailService;
use Src\LocalBodies\Models\LocalBody;
use Src\Settings\Models\FiscalYear;
use Livewire\Attributes\On;

class BuildingRegistrationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?Action $action;
    public ?CustomerLandDetail $customerLandDetail;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public ?MapApplyDetail $mapApplyDetail;
    public $constructionTypes;
    public $landDetails = [];
    public $isSameCustomer = false;
    public $landOwnerPhoto;

    public $uploadedFiles = [];
    public $customer_id;
    public bool $openModal = false;
    public bool $isModalForm = true;
    public bool $addLandForm = false;
    public $usageOptions;
    public $mapDocuments;
    public $provinces = [];
    public $districts = [];
    public $localBodies = [];
    public $wards = [];
    public $landOwnerProvinces = [];
    public $landOwnerDistricts = [];
    public $landOwnerLocalBodies = [];
    public $landOwnerWards = [];
    public $houseOwnerProvinces = [];
    public $houseOwnerDistricts = [];
    public $houseOwnerLocalBodies = [];
    public $houseOwnerWards = [];
    public $applicantProvinces = [];
    public $applicantDistricts = [];
    public $applicantLocalBodies = [];
    public $applicantWards = [];
    public $issuedDistricts= [];
    public $buildingStructures;
    public $mapProcessTypes;
    public $fiscalYears;
    public bool $isSame= false;
    public $houseOwnerPhoto;
    public $landOwnerDetail = [];
    public $applicantTypes ;
    public bool $showNameAndNumber = true;
    public $ownerships;
    public $fourBoundaries = [];
    public $organizations;
    public ?OrganizationDetail $organizationDetail;
    public $documents = [];
    public $formerLocalBodies;

    public $formerWards;

    public function rules(): array
    {
        $rules = [
            'landOwnerDetail.owner_name'  => ['required', 'string', 'max:255'],
            'landOwnerDetail.mobile_no'  => ['required'],
            'landOwnerDetail.father_name' => ['required', 'string', 'max:255'],
            'landOwnerDetail.grandfather_name' => ['required', 'string', 'max:255'],
            'landOwnerDetail.citizenship_no' => ['required'],
            'landOwnerDetail.citizenship_issued_at' => ['required'],
            'landOwnerDetail.citizenship_issued_date' => ['required'],
            'landOwnerDetail.province_id' => ['required'],
            'landOwnerDetail.district_id' => ['required'],
            'landOwnerDetail.local_body_id' => ['required'],
            'landOwnerDetail.ward_no' => ['required'],

            'mapApply.full_name'=> ['nullable'],
            'mapApply.age'      => ['nullable'],
            'mapApply.applied_date' => ['nullable'],
            'landOwnerPhoto'         => ['required'],
            'mapApply.is_applied_by_customer'=> ['nullable'],
            'mapApply.applicant_type'=> ['required'],

            'mapApply.area_of_building_plinth' => ['required'],
            'mapApply.no_of_rooms' => ['required'],
            'mapApply.storey_no' => ['required'],
            'mapApply.year_of_house_built' => ['required'],
            'mapApply.usage' => ['nullable'],
            'mapApply.building_structure' => ['nullable'],

            'mapApply.mobile_no' => ['nullable'],
            'mapApply.province_id' => ['required'],
            'mapApply.district_id' => ['required'],
            'mapApply.local_body_id' => ['required'],
            'mapApply.ward_no' => ['required'],
            'mapApply.application_date' => ['nullable'],
            'customerLandDetail.local_body_id' => ['required'],
            'customerLandDetail.former_local_body' => ['nullable'],
            'customerLandDetail.former_ward_no' => ['nullable'],
            'customerLandDetail.ward' => ['required'],
            'customerLandDetail.tole' => ['required'],
            'customerLandDetail.area_sqm' => ['required'],
            'customerLandDetail.lot_no' => ['required'],
            'customerLandDetail.seat_no' => ['required'],
            'customerLandDetail.ownership' => ['required'],
            'customerLandDetail.is_landlord' => ['nullable'],
            'mapApplyDetail.organization_id' => ['required'],

        ];


        if (!$this->isSame) {
            $rules['houseOwnerDetail.owner_name']  = ['required', 'string', 'max:255'];
            $rules['houseOwnerDetail.mobile_no']  = ['required'];
            $rules['houseOwnerDetail.father_name'] = ['required', 'string', 'max:255'];
            $rules['houseOwnerDetail.grandfather_name'] = ['required', 'string', 'max:255'];
            $rules['houseOwnerDetail.citizenship_no'] = ['required'];
            $rules['houseOwnerDetail.citizenship_issued_at'] = ['required'];
            $rules['houseOwnerDetail.citizenship_issued_date'] = ['required'];
            $rules['houseOwnerDetail.province_id'] = ['required'];
            $rules['houseOwnerDetail.district_id'] = ['required'];
            $rules['houseOwnerDetail.local_body_id'] = ['required'];
            $rules['houseOwnerDetail.ward_no'] = ['required'];
        }

        foreach ($this->uploadedFiles as $key => $file) {
            $rules["uploadedFiles.$key"] = 'max:1024'; // 1MB max
        }

        return $rules;
    }

    public function addFourBoundaries()
    {
        // Limit to 4 boundaries (matching DirectionEnum cases)
        if (count($this->fourBoundaries) >= 4) {
            $this->errorToast(__('ebps::ebps.maximum_four_boundaries_allowed'));
            return;
        }
        
        // Get the next available direction
        $usedDirections = collect($this->fourBoundaries)
            ->pluck('direction')
            ->filter()
            ->toArray();
        
        $availableDirections = collect(\Src\Ebps\Enums\DirectionEnum::cases())
            ->filter(function ($direction) use ($usedDirections) {
                return !in_array($direction->value, $usedDirections);
            });
        
        $nextDirection = $availableDirections->first();
        
        $this->fourBoundaries[] = [
            'title' => '',
            'direction' => $nextDirection ? $nextDirection->value : '',
            'distance' => '',
            'lot_no' => ''
        ];
    }

    public function removeFourBoundaries($index)
    {
        unset($this->fourBoundaries[$index]);
        $this->fourBoundaries = array_values($this->fourBoundaries);
    }

    public function getAvailableDirections($currentIndex)
    {
        $usedDirections = collect($this->fourBoundaries)
            ->pluck('direction')
            ->filter()
            ->toArray();
        
        $currentDirection = $this->fourBoundaries[$currentIndex]['direction'] ?? '';
        
        return collect(\Src\Ebps\Enums\DirectionEnum::cases())
            ->filter(function ($direction) use ($usedDirections, $currentDirection) {
                // Allow current direction to remain selected
                if ($direction->value === $currentDirection) {
                    return true;
                }
                // Filter out already used directions
                return !in_array($direction->value, $usedDirections);
            });
    }

    public function loadFourBoundaries($customerLandDetail)
    {
        $fourBoundaries = FourBoundary::where('land_detail_id', $customerLandDetail->id)->get();
        $this->fourBoundaries = [];

        foreach ($fourBoundaries as $boundary) {
            $this->fourBoundaries[] = [
                'title' => $boundary->title ?? '',
                'direction' => $boundary->direction ?? '',
                'distance' => $boundary->distance ?? '',
                'lot_no' => $boundary->lot_no ?? '',
            ];
        }
    }

    public function render(){
        return view("CustomerPortal.Ebps::livewire.building-registration-form");
    }

    public function isSameAsLandOwner()
    {
        $this->isSame = !$this->isSame;
    }

    public function getLandOwnerDistricts(): void
    {
        $this->landOwnerDistricts = getDistricts($this->landOwnerDetail['province_id'])->pluck('title', 'id')->toArray();

        $this->landOwnerLocalBodies = [];
        $this->landOwnerWards = [];
    }

    public function getLandOwnerLocalBodies(): void
    {
        $this->landOwnerLocalBodies = getLocalBodies($this->landOwnerDetail['district_id'])->pluck('title', 'id')->toArray();
        $this->landOwnerWards = [];
    }

    public function getLandOwnerWards(): void
    {
        $landLocalBody = LocalBody::find($this->landOwnerDetail['local_body_id']);
        $this->landOwnerWards = $landLocalBody ? getWards($landLocalBody->wards) : [];
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
    public function getApplicantDistricts(): void
    {
        $this->applicantDistricts = getDistricts($this->mapApply['province_id'])->pluck('title', 'id')->toArray();

        $this->applicantLocalBodies = [];
        $this->applicantWards = [];
    }

    public function getApplicantLocalBodies(): void
    {
        $this->applicantLocalBodies = LocalBody::where('district_id', $this->mapApply['district_id'])->pluck('title', 'id')->toArray();

        $this->applicantWards = [];
    }

    public function getApplicantWards(): void
    {
        $localBody = LocalBody::find($this->mapApply['local_body_id']);
        $this->applicantWards = $localBody ? getWards($localBody->wards) : [];
    }

    public function updateApplicantForm()
    {
        if($this->mapApply->applicant_type != ApplicantTypeEnum::HEIR )
        {
            $this->showNameAndNumber = !$this->showNameAndNumber;
        }
    }

     public function loadWards(): void
    {
        $localBody = LocalBody::find($this->customerLandDetail->local_body_id);
        
        if ($localBody) {
            $this->wards = getWards($localBody->wards);
        } else {
            $this->wards = [];
        }
    }

         public function loadFormerWards(): void
    {
        $localBody = LocalBody::find($this->customerLandDetail->former_local_body);

        if ($localBody) {
            $this->formerWards = getWards($localBody->wards);
        } else {
            $this->formerWards = [];
        }
    }

    public function mount(MapApply $mapApply,Action $action, CustomerLandDetail $customerLandDetail, HouseOwnerDetail $houseOwnerDetail, MapApplyDetail $mapApplyDetail, OrganizationDetail $organizationDetail)
    {

        $this->customerLandDetail = $customerLandDetail;
        $this->organizationDetail = $organizationDetail;
        $this->mapApplyDetail = new MapApplyDetail();
        $this->mapApply = $mapApply->load('landDetail', 'customer');
        $this->action = $action;
        $this->organizations = Organization::whereNull('deleted_at')->get();
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->get();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->applicantProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->landOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->houseOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->localBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerLocalBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerWards = [];

        $this->usageOptions = PurposeOfConstructionEnum::cases();
        $this->issuedDistricts = District::whereNull('deleted_at')->get();
        $this->mapDocuments = Document::whereNull('deleted_at')->where('application_type', ApplicationTypeEnum::BUILDING_DOCUMENTATION)->get();

        $this->wards = [];
        $this->buildingStructures = BuildingStructureEnum::cases();
        $this->mapProcessTypes = MapProcessTypeEnum::cases();
        $this->applicantTypes = ApplicantTypeEnum::cases();
        $this->ownerships = LandOwernshipEnum::cases();

        if ($this->action === Action::UPDATE) {
            $this->customer_id = $this->mapApply->customer_id;
            
             $this->landOwnerPhoto = $this->mapApply->signature;
            $this->mapApply->fiscal_year_id = getSetting('fiscal-year');
            $this->customerLandDetail = CustomerLandDetail::where('id', $mapApply->land_detail_id)->first() ?? [];
            $this->loadFourBoundaries($this->customerLandDetail);
            $this->houseOwnerDetail = HouseOwnerDetail::where('id', $this->mapApply->house_owner_id)->first();
            $this->landOwnerDetail = HouseOwnerDetail::where('id', $this->mapApply->land_owner_id)->first();
            $this->getLandOwnerDistricts();
            $this->getLandOwnerLocalBodies();
            $this->getLandOwnerWards();
            $this->getHouseOwnerDistricts();
            $this->getHouseOwnerLocalBodies();
            $this->getHouseOwnerWards();
            $this->getApplicantDistricts();
            $this->getApplicantLocalBodies();
            $this->getApplicantWards();
            $this->loadWards();
            $this->loadFormerWards();
        }
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        if($result['type'] === 'Customer')
        {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            $this->landOwnerDetail['owner_name'] = $customer->name;
            $this->landOwnerDetail['mobile_no'] = $customer->mobile_no;
            $this->landOwnerDetail['father_name'] = $customer->kyc->father_name;
            $this->landOwnerDetail['grandfather_name'] = $customer->kyc->grandfather_name;
            $this->landOwnerDetail['citizenship_no'] = $customer->kyc->document_number;
            $this->landOwnerDetail['citizenship_issued_date'] = $customer->kyc->document_issued_date_nepali;
            $this->landOwnerDetail['citizenship_issued_at'] = $customer->kyc->document_issued_at;
            $this->landOwnerDetail['province_id'] = $customer->kyc->permanent_province_id;
            $this->landOwnerDetail['district_id'] = $customer->kyc->permanent_district_id;
            $this->landOwnerDetail['local_body_id'] = $customer->kyc->permanent_local_body_id;
            $this->landOwnerDetail['ward_no'] = $customer->kyc->permanent_ward;
            $this->landOwnerDetail['permanent_tole'] = $customer->kyc->permanent_tole;
            $this->getLandOwnerDistricts();
            $this->getLandOwnerLocalBodies();
            $this->getLandOwnerWards();

        }else{

            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }

    }

    public function save()
    {
 $this->validate();
        $this->prepareMapApplyData();
        $dto = MapApplyAdminDto::fromLiveWireModel($this->mapApply);
        $landDetailDto = CustomerLandDetailDto::fromLiveWireModel($this->customerLandDetail);
        $houseOwnerDto = HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail);
        $detailArray = is_array($this->landOwnerDetail)
                ? $this->landOwnerDetail
                : $this->landOwnerDetail->toArray();

        $landOwnerDto= HouseOwnerDetailDto::fromArray($detailArray);
        $mapApplyDetailDto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);
        $organizationDetailDto = OrganizationDetailDto::fromLiveWireModel($this->organizationDetail);
        $organizationDetailService = new OrganizationDetailService();

        $service = new MapApplyAdminService();
        $ownerDetail = new HouseOwnerDetailService();
        $fourBoundaryService = new FourBoundaryAdminService();
        $landDetailService = new CustomerLandDetailService();
        $mapApplyDetailService = new MapApplyDetailAdminService();

        DB::beginTransaction();
        try{
        switch ($this->action){
            case Action::CREATE:
                $landDetail = $landDetailService->store($landDetailDto);

                foreach ($this->fourBoundaries as $fourBoundary) {
                    $fourBoundary['land_detail_id'] = $landDetail->id;
                    $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                    $fourBoundaryService->store($boundaryDto);
                }
                $houseOwner = $ownerDetail->store($houseOwnerDto);

                $landOwner = $ownerDetail->store($landOwnerDto);

                $dto->house_owner_id = $houseOwner->id;
                $dto->land_owner_id = $landOwner->id;
                $dto->land_detail_id = $landDetail->id;
                $mapApply = $service->store($dto);
                $mapApplyDetailDto->map_apply_id = $mapApply->id;
                $mapApplyDetailService->store($mapApplyDetailDto);
                $organizationDetailDto->map_apply_id = $mapApply->id;
                $organizationDetailService->store($organizationDetailDto);

                DB::commit();
                $this->successFlash(__("Application Created Successfully"));
                return redirect()->route('customer.ebps.building-registrations.index');
                break;
            case Action::UPDATE:
                $landDetailService->update($this->customerLandDetail,$landDetailDto);
                    FourBoundary::where('land_detail_id', $this->customerLandDetail->id)->delete();
                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $this->customerLandDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }
                    $houseOwner = $ownerDetail->update($this->mapApply->houseOwner, $houseOwnerDto);
                    $landOwner = $ownerDetail->update($this->mapApply->landOwner, $landOwnerDto);

                $mapApply = $service->update($this->mapApply,$dto);
                $mapApplyDetailService->update($this->mapApplyDetail, $mapApplyDetailDto);
                $organizationDetailService->update($this->organizationDetail, $organizationDetailDto);

                DB::commit();
                $this->successFlash(__("Application Updated Successfully"));
                return redirect()->route('customer.ebps.building-registrations.index');
                break;
            default:
                return redirect()->route('customer.ebps.building-registrations.index');
                break;
        }
    }  catch (\Exception $e) {
        logger($e);
        DB::rollBack();
        $this->errorFlash(__("An error occurred during operation. Please try again later"));
    }

    }

    private function prepareMapApplyData(): void
    {
        if (!$this->mapApply->submission_id) {
            $this->mapApply->submission_id = rand(1000000, 9999999);
        }

        $this->mapApply->fiscal_year_id = FiscalYear::where('year', $this->mapApply->fiscal_year_id)
            ->value('id');

         $this->landOwnerDetail['photo'] =  $this->processFiles($this->landOwnerPhoto);

        if ($this->isSame) {
            $this->houseOwnerDetail = new HouseOwnerDetail($this->landOwnerDetail);

        }else{
            $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);
        }
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $this->landOwnerDetail['ownership_type'] = OwnershipTypeEnum::LAND_OWNER->value;
        $this->mapApply->application_type = ApplicationTypeEnum::BUILDING_DOCUMENTATION->value;

        if($this->mapApply->applicant_type === ApplicantTypeEnum::HOUSE_OWNER->value)
        {
            $this->mapApply->full_name = $this->houseOwnerDetail->owner_name;
            $this->mapApply->mobile_no = $this->houseOwnerDetail->mobile_no;
        }
        if($this->mapApply->applicant_type === ApplicantTypeEnum::LAND_OWNER->value)
        {
            $this->mapApply->mobile_no = $this->landOwnerDetail['mobile_no'];
            $this->mapApply->full_name = $this->landOwnerDetail['owner_name'];
        }

        $this->organizationDetail->organization_id = $this->mapApplyDetail->organization_id;
        $organization = Organization::where('id', $this->organizationDetail->organization_id)->first();
        $this->organizationDetail->name = $organization->org_name_ne;
        $this->organizationDetail->contact_no = $organization->org_contact;
        $this->organizationDetail->email = $organization->org_email;
    }

    private function processFiles($file)
    {
        if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        {
           return ImageServiceFacade::compressAndStoreImage($file,  config('src.Ebps.ebps.path'), getStorageDisk('private'));
        }

        return $file;
    }

    private function storeFile($file): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
            return ImageServiceFacade::compressAndStoreImage($file, config('src.Ebps.ebps.path'), getStorageDisk('public'));
        }

        return FileFacade::saveFile(
            path: config('src.Ebps.ebps.path'),
            filename: null,
            file: $file,
            disk: getStorageDisk('private')
        );
    }

}
