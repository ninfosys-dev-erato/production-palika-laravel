<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Livewire\Component;
use Src\Ebps\DTO\OrganizationDetailDto;
use Src\Ebps\Enums\DocumentStatusEnum;
use Src\Customers\Models\Customer;
use Src\Districts\Models\District;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
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
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Models\DocumentFile;
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
    public $landOwnerPhoto;
    public $uploadedFiles = [];
    public $customer_id;
    public $provinces = [];
   
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
    public bool $showNameAndNumber = false;
    public $ownerships;
    public $fourBoundaries = [];
    public $organizations;
    public $usageOptions;
    public $mapDocuments = [];
    public $documents = [];
    public $options = [];
    public $formerLocalBodies;
    public $formerWards;
    public ?OrganizationDetail $organizationDetail;

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
            'mapApply.age' => ['nullable'],
            'mapApply.applied_date' => ['nullable'],
            'landOwnerPhoto'         => ['required'],
            'mapApply.is_applied_by_customer'=> ['nullable'],
            'mapApply.applicant_type'=> ['required'],
            'mapApply.area_of_building_plinth' => ['required'],
            'mapApply.no_of_rooms' => ['required'],
            'mapApply.storey_no' => ['required'],
            'mapApply.year_of_house_built' => ['required'],
            'mapApply.mobile_no' => ['nullable'],
            'mapApply.usage' => ['required'],
            'mapApply.building_structure' => ['required'],
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
        return view("Ebps::livewire.building-registration.building-registration-form");
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
        $this->applicantLocalBodies = getLocalBodies($this->mapApply['district_id'])->pluck('title', 'id')->toArray();
        $this->applicantWards = [];
    }

    public function getApplicantWards(): void
    {
        $localBody = LocalBody::find($this->mapApply['local_body_id']);
        $this->applicantWards = $localBody ? getWards($localBody->wards) : [];
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

    public function mount(
        MapApply $mapApply,
        Action $action,
        CustomerLandDetail $customerLandDetail,
        HouseOwnerDetail $houseOwnerDetail,
        MapApplyDetail $mapApplyDetail,
        OrganizationDetail $organizationDetail
    ) {
        $this->initializeDefaults();

        $this->mapApply = $mapApply->load('landDetail', 'customer');
        $this->customerLandDetail = $customerLandDetail;
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->mapApplyDetail = new MapApplyDetail();
        $this->action = $action;
        $this->mapDocuments = Document::whereNull('deleted_at')->where('application_type', ApplicationTypeEnum::MAP_APPLIES)->get();
        $this->options=DocumentStatusEnum::getForWeb();
        $this->documents = [];
        $this->organizationDetail = $organizationDetail;
        $this->formerLocalBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerWards = [];

        if ($this->action === Action::UPDATE) {
            $this->handleUpdateState();
        }
    }

    private function initializeDefaults(): void
    {
        $provinces = getProvinces()->pluck('title', 'id')->toArray();
        $districtId = key(getSettingWithKey('palika-district'));

        $this->usageOptions     = PurposeOfConstructionEnum::cases();
        $this->buildingStructures = BuildingStructureEnum::cases();
        $this->mapProcessTypes  = MapProcessTypeEnum::cases();
        $this->applicantTypes   = ApplicantTypeEnum::cases();
        $this->ownerships       = LandOwernshipEnum::cases();
        $this->organizations    = Organization::whereNull('deleted_at')->get();
        $this->fiscalYears      = FiscalYear::whereNull('deleted_at')->get();
        $this->issuedDistricts  = District::whereNull('deleted_at')->get();
        $this->localBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
       
        $this->provinces = $this->applicantProvinces = $this->landOwnerProvinces = $this->houseOwnerProvinces = $provinces;

        $this->wards = [];
        $this->mapDocuments = $this->mapDocuments ?? [];
        $this->uploadedFiles = $this->uploadedFiles ?? [];
    }

    private function handleUpdateState(): void
    {
        $this->customer_id = $this->mapApply->customer_id;
        $this->landOwnerPhoto = $this->mapApply->signature;
        $this->mapApply->fiscal_year_id = getSetting('fiscal-year');

        $this->customerLandDetail = CustomerLandDetail::find($this->mapApply->land_detail_id) ?? new CustomerLandDetail();
        $this->loadFourBoundaries($this->customerLandDetail);

        $this->houseOwnerDetail = HouseOwnerDetail::find($this->mapApply->house_owner_id) ?? new HouseOwnerDetail();
        $this->houseOwnerPhoto = $this->houseOwnerDetail->photo;
        $this->landOwnerDetail = HouseOwnerDetail::find($this->mapApply->land_owner_id) ?? new HouseOwnerDetail();
        $this->landOwnerPhoto = $this->landOwnerDetail->photo;

        $this->loadOwnerAndApplicantLocationData();
        $this->loadFormerWards();

        $this->mapApplyDetail = MapApplyDetail::where('map_apply_id', $this->mapApply->id)->first() ?? new MapApplyDetail();
        $this->loadStoredDocuments();
    }

    private function loadOwnerAndApplicantLocationData(): void
    {
        $this->getLandOwnerDistricts();
        $this->getLandOwnerLocalBodies();
        $this->getLandOwnerWards();

        $this->getHouseOwnerDistricts();
        $this->getHouseOwnerLocalBodies();
        $this->getHouseOwnerWards();

        $this->getApplicantDistricts();
        $this->getApplicantLocalBodies();
        $this->getApplicantWards();
    }

    private function loadStoredDocuments(): void
    {
        $storedDocuments = DocumentFile::where('map_apply_id', $this->mapApply->id)->whereNotNull('map_document_id')->get();
        $this->documents = DocumentFile::where(
            'map_apply_id', $this->mapApply->id)->whereNull('map_document_id')->get()->map(function ($document) {
            return array_merge($document->toArray(), [
                'url' => $document->url,
            ]);
        })
            ->toArray();
    

        foreach ($storedDocuments as $index => $document) {
            $this->uploadedFiles[$index] = $document->file;
            $this->mapDocuments[$index] = ['title' => $document->title];
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
            if($this->landOwnerDetail['province_id'])
            {
                $this->getLandOwnerDistricts();
            }
            if($this->landOwnerDetail['district_id'])
            {
                $this->getLandOwnerLocalBodies();
            }
            if($this->landOwnerDetail['local_body_id'])
            {
                $this->getLandOwnerWards();
            }         

        }else{
           
            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }

    }


    public function updated($propertyName,$value)
    {
        // Check if the property being updated is a file input
        if (preg_match('/^documents\.\d+\.document$/', $propertyName)) {
            $index = (int) filter_var($propertyName, FILTER_SANITIZE_NUMBER_INT);
            // Call the fileUpload method with the relevant index
            $this->fileUpload($index);
        }
    }

    public function fileUpload($index)
    {
        $save = FileFacade::saveFile(
            path:config('src.Ebps.ebps.path'),
            file:$this->documents[$index]['document'],
            disk:getStorageDisk('private'),
            filename:""
        );
        $this->documents[$index]['document'] = $save;
        $this->documents[$index]['document_status'] = DocumentStatusEnum::UPLOADED;
        $this->documents[$index]['url'] = FileFacade::getTemporaryUrl(
            path:config('src.Ebps.ebps.path'),
            filename:$save,
            disk:getStorageDisk('private')
        );
       
        $this->documents = array_values($this->documents);
    }

    public function addDocument(): void
    {
        $this->documents[]=[
            'document_name'=>null,
            'document_status'=>null,
            'document'=>null,
        ];
        $this->successToast(__('ebps::ebps.businessregistrationbusinessregistrationdocument_added_successfully'));
    }

    public function removeDocument(int $index): void{
        unset($this->documents[$index]);
        $this->successToast(__('ebps::ebps.businessregistrationbusinessregistrationdocument_successfully_removed'));
    }

    public function save()
    {
        
        $this->validate();
        $this->prepareMapApplyData();

        $dtos = $this->createDTOs();
        $services = $this->createServices();

        DB::beginTransaction();

        try {
            if ($this->action === Action::CREATE) {
                $this->handleCreate($dtos, $services);
                $this->successFlash(__('ebps::ebps.application_created_successfully'));
            } elseif ($this->action === Action::UPDATE) {
                $this->handleUpdate($dtos, $services);
                $this->successFlash(__('ebps::ebps.application_updated_successfully'));
            }

            DB::commit();
            return redirect()->route('admin.ebps.building-registrations.index');

        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    private function prepareMapApplyData(): void
    {
        $this->mapApply->submission_id ??= rand(1000000, 9999999);
        $this->mapApply->fiscal_year_id = FiscalYear::where('year', $this->mapApply->fiscal_year_id)->value('id');
        $this->landOwnerDetail['photo'] = $this->processFiles($this->landOwnerPhoto);

        if ($this->isSame) {
            $this->houseOwnerDetail = new HouseOwnerDetail($this->landOwnerDetail);
        } else {
            $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);
        }

        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $this->landOwnerDetail['ownership_type'] = OwnershipTypeEnum::LAND_OWNER->value;
        $this->mapApply->application_type = ApplicationTypeEnum::BUILDING_DOCUMENTATION->value;

        if ($this->mapApply->applicant_type === ApplicantTypeEnum::HOUSE_OWNER->value) {
            $this->mapApply->full_name = $this->houseOwnerDetail->owner_name;
            $this->mapApply->mobile_no = $this->houseOwnerDetail->mobile_no;
        }

        if ($this->mapApply->applicant_type === ApplicantTypeEnum::LAND_OWNER->value) {
            $this->mapApply->full_name = $this->landOwnerDetail['owner_name'];
            $this->mapApply->mobile_no = $this->landOwnerDetail['mobile_no'];
        }

        $this->organizationDetail->organization_id = $this->mapApplyDetail->organization_id;
        $organization = Organization::where('id', $this->organizationDetail->organization_id)->first();
        $this->organizationDetail->name = $organization->org_name_ne;
        $this->organizationDetail->contact_no = $organization->org_contact;
        $this->organizationDetail->email = $organization->org_email;
        
    }

    private function createDTOs(): array
    {
        return [
            'mapApplyDto'       => MapApplyAdminDto::fromLiveWireModel($this->mapApply),
            'landDetailDto'     => CustomerLandDetailDto::fromLiveWireModel($this->customerLandDetail),
            'houseOwnerDto'     => HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail),
            'landOwnerDto'      => HouseOwnerDetailDto::fromArray(is_array($this->landOwnerDetail) ? $this->landOwnerDetail : $this->landOwnerDetail->toArray()),
            'mapApplyDetailDto' => MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail),
            'organizationDetailDto' => OrganizationDetailDto::fromLiveWireModel($this->organizationDetail)
        ];
    }

    private function createServices(): array
    {
        return [
            'mapService'        => new MapApplyAdminService(),
            'ownerService'      => new HouseOwnerDetailService(),
            'boundaryService'   => new FourBoundaryAdminService(),
            'landDetailService' => new CustomerLandDetailService(),
            'detailService'     => new MapApplyDetailAdminService(),
            'organizationDetailService' => new OrganizationDetailService()
        ];
    }

    private function handleCreate(array $dtos, array $services): void
    {
        $landDetail = $services['landDetailService']->store($dtos['landDetailDto']);

        foreach ($this->fourBoundaries as $fourBoundary) {
            $fourBoundary['land_detail_id'] = $landDetail->id;
            $services['boundaryService']->store(FourBoundaryAdminDto::fromArray($fourBoundary));
        }

        $houseOwner = $services['ownerService']->store($dtos['houseOwnerDto']);
        $landOwner = $services['ownerService']->store($dtos['landOwnerDto']);

        $dtos['mapApplyDto']->house_owner_id = $houseOwner->id;
        $dtos['mapApplyDto']->land_owner_id = $landOwner->id;
        $dtos['mapApplyDto']->land_detail_id = $landDetail->id;

        $mapApply = $services['mapService']->store($dtos['mapApplyDto']);
        $dtos['mapApplyDetailDto']->map_apply_id = $mapApply->id;

        $services['detailService']->store($dtos['mapApplyDetailDto']);
        $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
       
        $dtos['organizationDetailDto']->map_apply_id = $mapApply->id;
        $services['organizationDetailService']->store($dtos['organizationDetailDto']);
    }

    private function handleUpdate(array $dtos, array $services): void
    {
        $services['landDetailService']->update($this->customerLandDetail, $dtos['landDetailDto']);

        FourBoundary::where('land_detail_id', $this->customerLandDetail->id)->delete();

        foreach ($this->fourBoundaries as $fourBoundary) {
            $fourBoundary['land_detail_id'] = $this->customerLandDetail->id;
            $services['boundaryService']->store(FourBoundaryAdminDto::fromArray($fourBoundary));
        }

        $services['ownerService']->update($this->mapApply->houseOwner, $dtos['houseOwnerDto']);
        $services['ownerService']->update($this->mapApply->landOwner, $dtos['landOwnerDto']);

        $services['mapService']->update($this->mapApply, $dtos['mapApplyDto']);
        $services['detailService']->update($this->mapApplyDetail, $dtos['mapApplyDetailDto']);

        $this->storeDocumentFiles($this->mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
        $services['organizationDetailService']->update($this->organizationDetail, $dtos['organizationDetailDto']);
    }

    private function storeDocumentFiles(int $mapApplyId, array $files, $mapDocuments, $documents): void
    {
        DocumentFile::where('map_apply_id', $mapApplyId)->delete();
        foreach ($files as $index => $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $storedPath = $this->processFiles($file);
                DocumentFile::create([
                    'map_apply_id' => $mapApplyId,
                    'title'        => $mapDocuments[$index]->title,
                    'file'         => $storedPath,
                    'status' =>  DocumentStatusEnum::UPLOADED,
                ]);
            }
        }

        foreach($documents as $index => $document) {
            if ($document['file']) {
                $storedPath = $this->processFiles($document['file']);
            }else{
                $storedPath = null;
            }
            DocumentFile::create([
                'map_apply_id' => $mapApplyId,
                'title'        => $document['title'],
                'file'         => $storedPath,
                'status' => $storedPath ? ($document['status'] ?? DocumentStatusEnum::UPLOADED) : DocumentStatusEnum::REQUESTED,
            ]);
        }
    }

    private function processFiles($file)
    {
        return $file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
            ? FileFacade::saveFile(config('src.Ebps.ebps.path'), "", $file, getStorageDisk('private'))
            : $file;
    }


    public function messages(): array
    {
        return [
            'landOwnerDetail.owner_name.required' => __('ebps::ebps.owner_name_is_required'),
            'landOwnerDetail.owner_name.string' => __('ebps::ebps.owner_name_must_be_a_string') ,
            'landOwnerDetail.owner_name.max' => __('ebps::ebps.owner_name_must_not_exceed_255_characters') ,
            'landOwnerDetail.mobile_no.required' => __('ebps::ebps.mobile_number_is_required') ,
            'landOwnerDetail.father_name.required' => __('Father\'s name is required') ,
            'landOwnerDetail.father_name.string' => __('Father\'s name must be a string') ,
            'landOwnerDetail.father_name.max' => __('Father\'s name must not exceed 255 characters') ,
            'landOwnerDetail.grandfather_name.required' => __('Grandfather\'s name is required') ,
            'landOwnerDetail.grandfather_name.string' => __('Grandfather\'s name must be a string') ,
            'landOwnerDetail.grandfather_name.max' => __('Grandfather\'s name must not exceed 255 characters') ,
            'landOwnerDetail.citizenship_no.required' => __('ebps::ebps.citizenship_number_is_required') ,
            'landOwnerDetail.citizenship_issued_at.required' => __('ebps::ebps.citizenship_issued_place_is_required') ,
            'landOwnerDetail.citizenship_issued_date.required' => __('ebps::ebps.citizenship_issued_date_is_required') ,
            'landOwnerDetail.province_id.required' => __('ebps::ebps.province_is_required') ,
            'landOwnerDetail.district_id.required' => __('ebps::ebps.district_is_required') ,
            'landOwnerDetail.local_body_id.required' => __('ebps::ebps.local_body_is_required') ,
            'landOwnerDetail.ward_no.required' => __('ebps::ebps.ward_number_is_required') ,
            'mapApply.full_name.nullable' => __('ebps::ebps.full_name_is_optional') ,
            'mapApply.age.nullable' => __('ebps::ebps.age_is_optional') ,
            'mapApply.applied_date.nullable' => __('ebps::ebps.applied_date_is_optional') ,
            'landOwnerPhoto.required' => __('ebps::ebps.owner_photo_is_required') ,
            'mapApply.is_applied_by_customer.nullable' => __('ebps::ebps.is_applied_by_customer_is_optional') ,
            'mapApply.applicant_type.required' => __('ebps::ebps.applicant_type_is_required') ,
            'mapApply.area_of_building_plinth.required' => __('ebps::ebps.area_of_building_plinth_is_required') ,
            'mapApply.no_of_rooms.required' => __('ebps::ebps.number_of_rooms_is_required') ,
            'mapApply.storey_no.required' => __('ebps::ebps.storey_number_is_required') ,
            'mapApply.year_of_house_built.required' => __('ebps::ebps.year_the_house_was_built_is_required') ,
            'mapApply.mobile_no.nullable' => __('ebps::ebps.mobile_number_is_optional') ,
            'mapApply.province_id.required' => __('ebps::ebps.map_province_is_required') ,
            'mapApply.district_id.required' => __('ebps::ebps.map_district_is_required') ,
            'mapApply.local_body_id.required' => __('ebps::ebps.map_local_body_is_required') ,
            'mapApply.ward_no.required' => __('ebps::ebps.map_ward_number_is_required') ,
            'mapApply.usage.required' => __('ebps::ebps.usage_is_required') ,
            'mapApply.building_structure.required' => __('ebps::ebps.building_structure_is_required') ,
            'mapApply.application_date.nullable' => __('ebps::ebps.application_date_is_optional') ,
            'customerLandDetail.local_body_id.required' => __('ebps::ebps.customer_land_local_body_is_required') ,
            'customerLandDetail.ward.required' => __('ebps::ebps.customer_land_ward_is_required') ,
            'customerLandDetail.tole.required' => __('ebps::ebps.customer_land_tole_is_required') ,
            'customerLandDetail.area_sqm.required' => __('ebps::ebps.customer_land_area_in_sqm_is_required') ,
            'customerLandDetail.lot_no.required' => __('ebps::ebps.customer_land_lot_number_is_required') ,
            'customerLandDetail.seat_no.required' => __('ebps::ebps.customer_land_seat_number_is_required') ,
            'customerLandDetail.ownership.required' => __('ebps::ebps.customer_land_ownership_is_required') ,
            'customerLandDetail.is_landlord.nullable' => __('ebps::ebps.is_landlord_is_optional') ,
            'mapApplyDetail.organization_id.required' => __('ebps::ebps.organization_id_is_required') ,
            'houseOwnerDetail.owner_name.required' => __('ebps::ebps.house_owner_name_is_required') ,
            'houseOwnerDetail.owner_name.string' => __('ebps::ebps.house_owner_name_must_be_a_string') ,
            'houseOwnerDetail.owner_name.max' => __('ebps::ebps.house_owner_name_must_not_exceed_255_characters') ,
            'houseOwnerDetail.mobile_no.required' => __('ebps::ebps.house_owner_mobile_number_is_required') ,
            'houseOwnerDetail.father_name.required' => __('House owner father\'s name is required') ,
            'houseOwnerDetail.father_name.string' => __('House owner father\'s name must be a string') ,
            'houseOwnerDetail.father_name.max' => __('House owner father\'s name must not exceed 255 characters') ,
            'houseOwnerDetail.grandfather_name.required' => __('House owner grandfather\'s name is required') ,
            'houseOwnerDetail.grandfather_name.string' => __('House owner grandfather\'s name must be a string') ,
            'houseOwnerDetail.grandfather_name.max' => __('House owner grandfather\'s name must not exceed 255 characters') ,
            'houseOwnerDetail.citizenship_no.required' => __('ebps::ebps.house_owner_citizenship_number_is_required') ,
            'houseOwnerDetail.citizenship_issued_at.required' => __('ebps::ebps.house_owner_citizenship_issued_place_is_required') ,
            'houseOwnerDetail.citizenship_issued_date.required' => __('ebps::ebps.house_owner_citizenship_issued_date_is_required') ,
            'houseOwnerDetail.province_id.required' => __('ebps::ebps.house_owner_province_is_required') ,
            'houseOwnerDetail.district_id.required' => __('ebps::ebps.house_owner_district_is_required') ,
            'houseOwnerDetail.local_body_id.required' => __('ebps::ebps.house_owner_local_body_is_required') ,
            'houseOwnerDetail.ward_no.required' => __('ebps::ebps.house_owner_ward_number_is_required') ,
        ];
    }

}
