<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\DTO\OrganizationDetailDto;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\DocumentStatusEnum;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Enums\OwnershipTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
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
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Models\Document;
use Src\Ebps\Models\DocumentFile;
use Illuminate\Support\Facades\DB;
use Src\Ebps\Service\MapApplyDetailAdminService;
use Src\Ebps\Service\OrganizationDetailService;
use Src\LocalBodies\Models\LocalBody;
use Src\Settings\Models\FiscalYear;
use Livewire\Attributes\On;

class CustomerMapApplyForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?Action $action;
    public ?CustomerLandDetail $customerLandDetail;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public ?MapApplyDetail $mapApplyDetail;
    public ?OrganizationDetail $organizationDetail;
    public $constructionTypes;
    public $landDetails = [];
    public $isSameCustomer = false;
    public $uploadedImage;
    public $mapDocuments;
    public $uploadedFiles = [];
    public $customer_id;
    public bool $openModal = false;
    public bool $isModalForm = true;
    public bool $addLandForm = false;
    public $localBodies;
    public $wards;
    public $formerWards;
    public $ownerships;
    public $fourBoundaries = [];
    public bool $is_boundary = false;
    public $issuedDistricts;
    public $houseOwnerProvinces = [];
    public $houseOwnerPhoto;
    public $houseOwnerPhotoUrl;
    public $uploadedImageUrl;
    public $uploadedFilesUrls = [];
    public $usageOptions;
    public $documents = [];
    public $options = [];
    public $organizations;
    public $formerLocalBodies;

    public function rules(): array
    {
        if ($this->addLandForm) {
            return [
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
            ];
        }
        $rules = [
            'mapApply.fiscal_year_id' => ['nullable'],
            'mapApply.construction_type_id' => ['required'],
            'mapApply.usage' => ['required'],
            'mapApply.full_name' => ['nullable'],
            'mapApply.age' => ['nullable'],
            'mapApply.applied_date' => ['required'],
            'uploadedImage' => ['required'],
            'mapApply.is_applied_by_customer' => ['nullable'],
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

        foreach ($this->uploadedFiles as $key => $file) {
            $rules["uploadedFiles.$key"] = 'max:1024'; // 1MB max
        }

        return $rules;
    }

    public function render()
    {

        return view("CustomerPortal.Ebps::livewire.map-applies-form");

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

        if($index == 0)
        {
            $this->is_boundary = !$this->is_boundary;
        }
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

    public function mount(MapApply $mapApply, Action $action, CustomerLandDetail $customerLandDetail, HouseOwnerDetail $houseOwnerDetail, MapApplyDetail $mapApplyDetail, OrganizationDetail $organizationDetail)
    {
        $this->customerLandDetail = $customerLandDetail;

        $this->usageOptions = PurposeOfConstructionEnum::cases();
        $this->mapApplyDetail = new MapApplyDetail();
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->organizationDetail = $organizationDetail;
        $this->organizations  = Organization::whereNull('deleted_at')->get();
        $this->mapApply = $mapApply->load('landDetail', 'customer');
        $this->action = $action;
        $this->mapApply->fiscal_year_id = getSetting('fiscal-year');
        $this->mapApply->submission_id = rand(1000000, 9999999);
        $this->constructionTypes = ConstructionType::whereNull('deleted_at')->get();
        $this->landDetails = CustomerLandDetail::where('customer_id', $this->customer_id)->get() ?? [];
        $this->houseOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();

        $this->localBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerLocalBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerWards = [];
        
        $this->ownerships = LandOwernshipEnum::cases();
        $this->wards = [];
        $this->mapDocuments = Document::whereNull('deleted_at')->where('application_type', ApplicationTypeEnum::MAP_APPLIES)->get();
        $this->options=DocumentStatusEnum::getForWeb();
        $this->documents = [];
        $this->uploadedFiles = $this->uploadedFiles ?? [];

        if ($this->action === Action::UPDATE) {
            $this->customer_id = $this->mapApply->customer_id;
            $this->uploadedImage = $this->mapApply->signature;
            if (!empty($this->mapApply->signature)) {
                $this->uploadedImageUrl = FileFacade::getTemporaryUrl(
                    path: config('src.Ebps.ebps.path'),
                    filename: $this->mapApply->signature,
                    disk: getStorageDisk('private')
                );
            }
            $this->mapApply->fiscal_year_id = getSetting('fiscal-year');

            $this->houseOwnerDetail = HouseOwnerDetail::where('id', $this->mapApply->house_owner_id)->first();
            $this->houseOwnerPhoto = $this->houseOwnerDetail->photo;
            if (!empty($this->houseOwnerDetail->photo)) {
                $this->houseOwnerPhotoUrl = FileFacade::getTemporaryUrl(
                    path: config('src.Ebps.ebps.path'),
                    filename: $this->houseOwnerDetail->photo,
                    disk: getStorageDisk('private')
                );
            }
            $storedDocuments = DocumentFile::where('map_apply_id', $this->mapApply->id)->whereNotNull('map_document_id')->get();
            $this->documents = DocumentFile::where(
            'map_apply_id', $this->mapApply->id)->whereNull('map_document_id')->get()->map(function ($document) {
            return [
                'title' => $document->title,
                'status' => $document->status,
                'document' => $document->file,
                'url' => !empty($document->file) ? FileFacade::getTemporaryUrl(
                    path: config('src.Ebps.ebps.path'),
                    filename: $document->file,
                    disk: getStorageDisk('private')
                ) : null,
            ];
            })
            ->toArray();
    

            // Map stored documents to the correct mapDocuments indices
            foreach ($storedDocuments as $storedDocument) {
                // Find the index of the document in mapDocuments collection
                $documentIndex = $this->mapDocuments->search(function ($doc) use ($storedDocument) {
                    return $doc->id == $storedDocument->map_document_id;
                });
                
                if ($documentIndex !== false) {
                    $this->uploadedFiles[$documentIndex] = $storedDocument->file;
                    if (!empty($storedDocument->file)) {
                        $this->uploadedFilesUrls[$documentIndex] = FileFacade::getTemporaryUrl(
                            path: config('src.Ebps.ebps.path'),
                            filename: $storedDocument->file,
                            disk: getStorageDisk('private')
                        );
                    }
                }
            }
             $this->customerLandDetail = CustomerLandDetail::where('id', $mapApply->land_detail_id)->first() ?? [];
             $this->mapApplyDetail = MapApplyDetail::where('map_apply_id', $this->mapApply->id)->first() ?? new MapApplyDetail();
            $this->loadFourBoundaries($this->customerLandDetail);
             $this->loadWards();
             $this->loadFormerWards();
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

        // Handle houseOwnerPhoto file upload
        if ($propertyName === 'houseOwnerPhoto') {
            $this->handleFileUpload($value, 'photo', null, 'houseOwner');
        }

        // Handle uploadedImage file upload
        if ($propertyName === 'uploadedImage') {
            $this->handleFileUpload($value, 'signature', null, 'signature');
        }

        // Handle uploadedFiles file upload
        if (preg_match('/^uploadedFiles\.(\d+)$/', $propertyName, $matches)) {
            $index = (int) $matches[1];
            $this->handleFileUpload($value, 'file', $index, 'uploadedFiles');
        }

        // Handle former local body changes
        if ($propertyName === 'customerLandDetail.former_local_body') {
            $this->loadFormerWards();
        }
    }


    public function fileUpload($index)
    {
        $save = FileFacade::saveFile(
            path:config('src.Ebps.ebps.path'),
            file:$this->documents[$index]['document'],
            disk: getStorageDisk('private'),
            filename:""
        );
        $this->documents[$index]['document'] = $save;
        $this->documents[$index]['status'] = DocumentStatusEnum::UPLOADED;
        $this->documents[$index]['url'] = FileFacade::getTemporaryUrl(
            path:config('src.Ebps.ebps.path'),
            filename:$save,
            disk: getStorageDisk('private')
        );
       
        $this->documents = array_values($this->documents);
    }

    private function handleFileUpload($file, $field, $index = null, $target = 'houseOwner')
    {
        if (!$file) return;

        if (is_string($file)) {
            $filename = $file;
        } else {
            $filename = FileFacade::saveFile(
                path: config('src.Ebps.ebps.path'),
                filename: '',
                file: $file,
                disk: getStorageDisk('private'),
            );
        }

        $url = FileFacade::getTemporaryUrl(
            path: config('src.Ebps.ebps.path'),
            filename: $filename,
            disk: getStorageDisk('private')
        );

        if ($target === 'houseOwner') {
            $this->houseOwnerPhoto = $filename;
            $this->houseOwnerPhotoUrl = $url;
        } elseif ($target === 'signature') {
            $this->uploadedImage = $filename;
            $this->uploadedImageUrl = $url;
        } elseif ($target === 'uploadedFiles') {
            $this->uploadedFiles[$index] = $filename;
            $this->uploadedFilesUrls[$index] = $url;
        }
    }


    public function addDocument(): void
    {
        $this->documents[]=[
            'title'=>null,
            'status'=>null,
            'document'=>null,
        ];
        $this->successToast(__('businessregistration::businessregistration.document_added_successfully'));
    }

    public function removeDocument(int $index): void{
        unset($this->documents[$index]);
        $this->successToast(__('businessregistration::businessregistration.document_successfully_removed'));
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

    public function save()
    {

        $this->validate();
        $this->prepareMapApplyData();
        $this->mapApply->application_type = ApplicationTypeEnum::MAP_APPLIES->value;

        $dto = MapApplyAdminDto::fromLiveWireModel($this->mapApply);
        $mapApplyService = new MapApplyAdminService();
        $landDto = CustomerLandDetailDto::fromLiveWireModel($this->customerLandDetail);
        $mapApplyDetailDto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);
        $houseOwnerDto = HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail);
     

        $this->organizationDetail->organization_id = $this->mapApplyDetail->organization_id;
        $organization = Organization::where('id', $this->organizationDetail->organization_id)->first();
        $this->organizationDetail->name = $organization->org_name_ne;
        $this->organizationDetail->contact_no = $organization->org_contact;
        $this->organizationDetail->email = $organization->org_email;
   
        $organizationDetailDto = OrganizationDetailDto::fromLiveWireModel($this->organizationDetail);

        $landService = new CustomerLandDetailService();
        $fourBoundaryService = new FourBoundaryAdminService();
        $ownerDetail = new HouseOwnerDetailService();
        $mapApplyDetailService = new MapApplyDetailAdminService();
        $organizationDetailService = new OrganizationDetailService();
        DB::beginTransaction();
        try{
        switch ($this->action){
            case Action::CREATE:
                $landDetail = $landService->store($landDto);

                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $landDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }

                $houseOwner = $ownerDetail->store( $houseOwnerDto);
                $dto->house_owner_id = $houseOwner->id;
                $dto->land_detail_id = $landDetail->id;
                $mapApply = $mapApplyService->store($dto);

                $mapApplyDetailDto->map_apply_id = $mapApply->id;
                $mapApplyDetailService->store($mapApplyDetailDto);
                $organizationDetailDto->map_apply_id = $mapApply->id;
                $organizationDetailService->store($organizationDetailDto);
                $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
                DB::commit();
                $this->successFlash(__("ebps::ebps.map_apply_created_successfully"));
                return redirect()->route('customer.ebps.apply.map-apply.index');
                break;
            case Action::UPDATE:
                 $landService->update($this->customerLandDetail,$landDto);
                    FourBoundary::where('land_detail_id', $this->customerLandDetail->id)->delete();
                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $this->customerLandDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }
                $houseOwner = $ownerDetail->update($this->mapApply->houseOwner, $houseOwnerDto);
                $mapApply = $mapApplyService->update($this->mapApply,$dto);
                $mapApplyDetailService->update($this->mapApplyDetail, $mapApplyDetailDto);
                $organizationDetailService->update($this->organizationDetail, $organizationDetailDto);
                $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
                DB::commit();
                $this->successFlash(__("ebps::ebps.map_apply_updated_successfully"));
                return redirect()->route('customer.ebps.apply.map-apply.index');
                break;
            default:
                return redirect()->route('customer.ebps.apply.map-apply.index');
                break;
        }
        }  catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__("ebps::ebps.an_error_occurred_during_operation_please_try_again_later"));
        }

    }

    private function prepareMapApplyData(): void
    {
        if (!$this->mapApply->submission_id) {
            $this->mapApply->submission_id = rand(1000000, 9999999);
        }

        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
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

        $this->mapApply->full_name = $this->houseOwnerDetail->owner_name;
        $this->mapApply->mobile_no = $this->houseOwnerDetail->mobile_no;
        $this->mapApply->province_id = $this->houseOwnerDetail->province_id;
        $this->mapApply->district_id = $this->houseOwnerDetail->district_id;
        $this->mapApply->local_body_id = $this->houseOwnerDetail->local_body_id;
        $this->mapApply->ward_no = $this->houseOwnerDetail->ward_no;

        $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $this->mapApply->signature=  $this->uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ?
            $this->processFiles($this->uploadedImage)
                :
            $this->uploadedImage;

        $this->mapApply->fiscal_year_id = FiscalYear::where('year', $this->mapApply->fiscal_year_id)
            ->value('id');
    }
    private function storeDocumentFiles(int $mapApplyId, array $files, $mapDocuments, $documents): void
    {
        DocumentFile::where('map_apply_id', $mapApplyId)->delete();
        
        // Handle mapDocuments (required documents)
        foreach ($files as $index => $file) {
            if ($file) {
                $storedPath = $this->processFiles($file);
                $documentTitle = '';
                $mapDocumentId = null;
                
                // Handle different types of mapDocuments
                if (isset($mapDocuments[$index])) {
                    if (is_object($mapDocuments[$index])) {
                        $documentTitle = $mapDocuments[$index]->title;
                        //$mapDocumentId = $mapDocuments[$index]->id;
                    } elseif (is_array($mapDocuments[$index])) {
                        $documentTitle = $mapDocuments[$index]['title'] ?? '';
                    }
                }
                
                DocumentFile::create([
                    'map_apply_id' => $mapApplyId,
                    'map_document_id' => $mapDocumentId,
                    'title'        => $documentTitle,
                    'file'         => $storedPath,
                    'status' =>  DocumentStatusEnum::UPLOADED,
                ]);
            }
        }

        // Handle additional documents
        foreach($documents as $index => $document) {
            $storedPath = null;
            if (isset($document['document']) && $document['document']) {
                $storedPath = $this->processFiles($document['document']);
            } elseif (isset($document['file']) && $document['file']) {
                $storedPath = $this->processFiles($document['file']);
            }
            
            DocumentFile::create([
                'map_apply_id' => $mapApplyId,
                'title'        => $document['title'] ?? '',
                'file'         => $storedPath,
                'status' => $storedPath ? ($document['status'] ?? DocumentStatusEnum::UPLOADED) : DocumentStatusEnum::REQUESTED,
            ]);
        }
    }

    private function processFiles($file)
    {
        if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        {
           return FileFacade::saveFile( config('src.Ebps.ebps.path'), "", $file, getStorageDisk('private'));
        }else{
            return $file;
        }
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
