<?php

namespace Src\Ebps\Livewire;

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
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\BuildingStructureEnum;
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

class MapApplyForm extends Component
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
    public $ownerships;
    public $fourBoundaries = [];
    public bool $is_boundary = false;
    public $issuedDistricts = [];
    public $houseOwnerProvinces = [];
    public $houseOwnerDistricts = [];
    public $houseOwnerLocalBodies = [];
    public $houseOwnerWards = [];
    public $houseOwnerPhoto;
    public $usageOptions;
    public $buildingStructures;
    public $documents = [];
    public $options = [];
    public $organizations;
    public $formerLocalBodies;
    public $formerWards;

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
            'mapApply.building_structure' => ['required'],
            'mapApplyDetail.organization_id' => ['required'],
        ];

        foreach ($this->uploadedFiles as $key => $file) {
            $rules["uploadedFiles.$key"] = 'max:1024'; // 1MB max
        }

        return $rules;
    }

    public function render()
    {
        return view("Ebps::livewire.map-applies.map-applies-form");
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        if ($result['type'] === 'Customer') {
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
        } else {

            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }
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
        $this->fourBoundaries[] = [
            'title' => '',
            'direction' => '',
            'distance' => '',
            'lot_no' => ''
        ];
    }

    public function removeFourBoundaries($index)
    {
        unset($this->fourBoundaries[$index]);
        $this->fourBoundaries = array_values($this->fourBoundaries);

        if ($index == 0) {
            $this->is_boundary = !$this->is_boundary;
        }
    }

    public function loadLandDetails()
    {
        $this->landDetails = CustomerLandDetail::where('customer_id', $this->customer_id)->get() ?? [];
    }

    public function mount(MapApply $mapApply, Action $action, CustomerLandDetail $customerLandDetail, HouseOwnerDetail $houseOwnerDetail,  MapApplyDetail $mapApplyDetail, OrganizationDetail $organizationDetail)
    {
        $this->customerLandDetail = $customerLandDetail;
        $this->usageOptions = PurposeOfConstructionEnum::cases();
        $this->houseOwnerDetail = $houseOwnerDetail;
        $this->mapApply = $mapApply->load('landDetail', 'customer');
        $this->action = $action;
        $this->mapApply->fiscal_year_id = getSetting('fiscal-year');
        $this->mapApply->submission_id = rand(1000000, 9999999);
        $this->constructionTypes = ConstructionType::whereNull('deleted_at')->get();
        $this->buildingStructures = BuildingStructureEnum::cases();
        $this->landDetails = CustomerLandDetail::where('customer_id', $this->customer_id)->get() ?? [];
        $this->houseOwnerProvinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->mapApplyDetail = new MapApplyDetail();

        $this->organizations  = Organization::whereNull('deleted_at')->get();
        $this->localBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->formerLocalBodies = LocalBody::where('district_id', key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();

        // $this->localBodies = getLocalBodies(district_ids: key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->ownerships = LandOwernshipEnum::cases();
        $this->issuedDistricts = District::whereNull('deleted_at')->get();
        $this->wards = [];
        $this->formerWards = [];
        $this->organizationDetail = $organizationDetail;

        $this->mapDocuments = Document::whereNull('deleted_at')->where('application_type', ApplicationTypeEnum::MAP_APPLIES)->get();
        $this->options = DocumentStatusEnum::getForWeb();
        $this->documents = [];

        if ($this->action === Action::UPDATE) {
            $this->customer_id = $this->mapApply->customer_id;
            $this->uploadedImage = $this->mapApply->signature;
            $this->mapApply->fiscal_year_id = getSetting('fiscal-year');


            $this->houseOwnerDetail = HouseOwnerDetail::where('id', $this->mapApply->house_owner_id)->first();
            $this->houseOwnerPhoto = $this->houseOwnerDetail->photo;
            $storedDocuments = DocumentFile::where('map_apply_id', $this->mapApply->id)->whereNotNull('map_document_id')->get();
            $this->documents = DocumentFile::where(
                'map_apply_id',
                $this->mapApply->id
            )->whereNull('map_document_id')->get()->map(function ($document) {
                return array_merge($document->toArray(), [
                    'url' => $document->url,
                ]);
            })
                ->toArray();
            $this->mapApplyDetail = MapApplyDetail::where('map_apply_id', $this->mapApply->id)->first() ?? new MapApplyDetail();

            $this->getHouseOwnerDistricts();
            $this->getHouseOwnerLocalBodies();
            $this->getHouseOwnerWards();



            foreach ($storedDocuments as $index => $document) {
                $this->uploadedFiles[$index] = $document->file;
                $this->mapDocuments[$index] = ['title' => $document->title];
            }
            $this->customerLandDetail = CustomerLandDetail::where('id', $mapApply->land_detail_id)->first() ?? [];
            $this->loadWards();
            $this->loadFormerWards();
            $this->loadFourBoundaries($this->customerLandDetail);
        }
    }

    public function updated($propertyName, $value)
    {
        // Check if the property being updated is a file input
        if (preg_match('/^documents\.\d+\.document$/', $propertyName)) {
            $index = (int) filter_var($propertyName, FILTER_SANITIZE_NUMBER_INT);
            // Call the fileUpload method with the relevant index
            $this->fileUpload($index);
        }

        // Handle former local body changes
        if ($propertyName === 'customerLandDetail.former_local_body') {
            $this->loadFormerWards();
        }
    }

    public function fileUpload($index)
    {
        $save = FileFacade::saveFile(
            path: config('src.Ebps.ebps.path'),
            file: $this->documents[$index]['document'],
            disk: "local",
            filename: ""
        );
        $this->documents[$index]['document'] = $save;
        $this->documents[$index]['document_status'] = DocumentStatusEnum::UPLOADED;
        $this->documents[$index]['url'] = FileFacade::getTemporaryUrl(
            path: config('src.Ebps.ebps.path'),
            filename: $save,
            disk: 'local'
        );

        $this->documents = array_values($this->documents);
    }


    public function addDocument(): void
    {
        $this->documents[] = [
            'document_name' => null,
            'document_status' => null,
            'document' => null,
        ];
        $this->successToast(__('ebps::ebps.businessregistrationbusinessregistrationdocument_added_successfully'));
    }

    public function removeDocument(int $index): void
    {
        unset($this->documents[$index]);
        $this->successToast(__('ebps::ebps.businessregistrationbusinessregistrationdocument_successfully_removed'));
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
        $landDto = CustomerLandDetailDto::fromLiveWireModel($this->customerLandDetail);
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $houseOwnerDto = HouseOwnerDetailDto::fromLiveWireModel($this->houseOwnerDetail);
        // dd($houseOwnerDto);
        $mapApplyDetailDto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);

        $this->organizationDetail->organization_id = $this->mapApplyDetail->organization_id;
        $organization = Organization::where('id', $this->organizationDetail->organization_id)->first();
        $this->organizationDetail->name = $organization->org_name_ne;
        $this->organizationDetail->contact_no = $organization->org_contact;
        $this->organizationDetail->email = $organization->org_email;

        $organizationDetailDto = OrganizationDetailDto::fromLiveWireModel($this->organizationDetail);

        $mapApplyService = new MapApplyAdminService();
        $ownerDetail = new HouseOwnerDetailService();
        $landService = new CustomerLandDetailService();
        $fourBoundaryService = new FourBoundaryAdminService();
        $mapApplyDetailService = new MapApplyDetailAdminService();
        $organizationDetailService = new OrganizationDetailService();

        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $landDetail = $landService->store($landDto);

                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $landDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }

                    $houseOwner = $ownerDetail->store($houseOwnerDto);
                    $dto->house_owner_id = $houseOwner->id;
                    $dto->land_detail_id = $landDetail->id;
                    $mapApply = $mapApplyService->store($dto);
                    $mapApplyDetailDto->map_apply_id = $mapApply->id;
                    $mapApplyDetailService->store($mapApplyDetailDto);
                    $organizationDetailDto->map_apply_id = $mapApply->id;
                    $organizationDetailService->store($organizationDetailDto);

                    $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_apply_created_successfully'));

                    return redirect()->route('admin.ebps.map_applies.index');

                case Action::UPDATE:
                    $landService->update($this->customerLandDetail, $landDto);
                    FourBoundary::where('land_detail_id', $this->customerLandDetail->id)->delete();
                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $this->customerLandDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }
                    $houseOwner = $ownerDetail->update($this->mapApply->houseOwner, $houseOwnerDto);
                    $mapApply = $mapApplyService->update($this->mapApply, $dto);
                    $mapApplyDetailService->update($this->mapApplyDetail, $mapApplyDetailDto);
                    $organizationDetailService->update($this->organizationDetail, $organizationDetailDto);
                    $this->storeDocumentFiles($mapApply->id, $this->uploadedFiles, $this->mapDocuments, $this->documents);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_apply_updated_successfully'));
                    return redirect()->route('admin.ebps.map_applies.index');
                    break;
                default:
                    return redirect()->route('admin.ebps.map_applies.index');
                    break;
            }
        } catch (\Exception $e) {
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

        $this->mapApply->full_name = $this->houseOwnerDetail->owner_name;
        $this->mapApply->mobile_no = $this->houseOwnerDetail->mobile_no;
        $this->mapApply->province_id = $this->houseOwnerDetail->province_id;
        $this->mapApply->district_id = $this->houseOwnerDetail->district_id;
        $this->mapApply->local_body_id = $this->houseOwnerDetail->local_body_id;
        $this->mapApply->ward_no = $this->houseOwnerDetail->ward_no;
        $this->houseOwnerDetail->ownership_type = OwnershipTypeEnum::HOUSE_OWNER->value;
        $this->houseOwnerDetail->photo = $this->processFiles($this->houseOwnerPhoto);
        $this->mapApply->signature =  $this->uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ?
            $this->processFiles($this->uploadedImage)
            :
            $this->uploadedImage;

        $this->mapApply->fiscal_year_id = FiscalYear::where('year', $this->mapApply->fiscal_year_id)
            ->value('id');
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

        foreach ($documents as $index => $document) {
            if ($document['file']) {
                $storedPath = $this->processFiles($document['file']);
            } else {
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
        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return FileFacade::saveFile(config('src.Ebps.ebps.path'), "", $file, 'local');
        } else {
            return $file;
        }
    }

    public function messages(): array
    {
        return [
            'customerLandDetail.local_body_id.required' => __('ebps::ebps.local_body_is_required'),
            'customerLandDetail.ward.required' => __('ebps::ebps.ward_number_is_required'),
            'customerLandDetail.tole.required' => __('ebps::ebps.tole_is_required'),
            'customerLandDetail.area_sqm.required' => __('ebps::ebps.area_in_sqm_is_required'),
            'customerLandDetail.lot_no.required' => __('ebps::ebps.lot_number_is_required'),
            'customerLandDetail.seat_no.required' => __('ebps::ebps.seat_number_is_required'),
            'customerLandDetail.ownership.required' => __('ebps::ebps.ownership_is_required'),
            'mapApply.construction_type_id.required' => __('ebps::ebps.construction_type_is_required'),
            'mapApply.usage.required' => __('ebps::ebps.usage_is_required'),
            'mapApply.applied_date.required' => __('ebps::ebps.applied_date_is_required'),
            'mapApply.building_structure.required' => __('ebps::ebps.building_structure_is_required'),
            'uploadedImage.required' => __('ebps::ebps.image_upload_is_required'),
            'houseOwnerDetail.owner_name.required' => __('ebps::ebps.house_owner_name_is_required'),
            'houseOwnerDetail.owner_name.string' => __('ebps::ebps.house_owner_name_must_be_a_string'),
            'houseOwnerDetail.owner_name.max' => __('ebps::ebps.house_owner_name_must_not_exceed_255_characters'),
            'houseOwnerDetail.mobile_no.required' => __('ebps::ebps.mobile_number_is_required'),
            'houseOwnerDetail.father_name.required' => __('ebps::ebps.fathers_name_is_required'),
            'houseOwnerDetail.father_name.string' => __('ebps::ebps.fathers_name_must_be_a_string'),
            'houseOwnerDetail.father_name.max' => __('ebps::ebps.fathers_name_must_not_exceed_255_characters'),
            'houseOwnerDetail.grandfather_name.required' => __('ebps::ebps.grandfathers_name_is_required'),
            'houseOwnerDetail.grandfather_name.string' => __('ebps::ebps.grandfathers_name_must_be_a_string'),
            'houseOwnerDetail.grandfather_name.max' => __('ebps::ebps.grandfathers_name_must_not_exceed_255_characters'),
            'houseOwnerDetail.citizenship_no.required' => __('ebps::ebps.citizenship_number_is_required'),
            'houseOwnerDetail.citizenship_issued_at.required' => __('ebps::ebps.citizenship_issued_place_is_required'),
            'houseOwnerDetail.citizenship_issued_date.required' => __('ebps::ebps.citizenship_issued_date_is_required'),
            'houseOwnerDetail.province_id.required' => __('ebps::ebps.province_is_required'),
            'houseOwnerDetail.district_id.required' => __('ebps::ebps.district_is_required'),
            'houseOwnerDetail.local_body_id.required' => __('ebps::ebps.local_body_is_required'),
            'houseOwnerDetail.ward_no.required' => __('ebps::ebps.ward_number_is_required'),
            'uploadedFiles.*.max' => __('ebps::ebps.each_uploaded_file_must_not_exceed_1mb'),
        ];
    }
}
