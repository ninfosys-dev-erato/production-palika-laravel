<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\DTO\OrganizationDetailDto;
use Src\Ebps\Enums\DocumentTypeEnum;
use Src\Ebps\Models\MapApply;
use App\Facades\ImageServiceFacade;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Models\DocumentFile;
use Src\Ebps\Models\OrganizationDetail;
use Src\Ebps\Models\Organization;
use Src\Ebps\Service\OrganizationDetailService;

class ChangeOrganizationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?Action $action;
    public ?OrganizationDetail $organizationDetail;
    public $organizations = [];
    public $oldOrganizationId;
    

    public function rules(): array
    {
        $rules = [
            'organizationDetail.registration_date' => ['required'],
            'organizationDetail.organization_id' => ['required'],
            'organizationDetail.reason_of_organization_change' => ['required'],
            
        ];

        return $rules;
    }

   
    public function render(){
        return view("Ebps::livewire.change-organization");
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

    public function mount(MapApply $mapApply, OrganizationDetail $organizationDetail)
    {
        
        $this->mapApply = $mapApply->load([
        'landDetail', 'customer', 'detail',
        'organizationDetails' => fn ($q) => $q->with('parentRecursive')
    ]);

        
        $this->organizationDetail = $organizationDetail;

        $this->organizations = Organization::whereNull('deleted_at')->get();
      
    }

    public function save()
    {   
        $this->validate();

        $latestOrganizationDetail = $this->mapApply->organizationDetails()->latest()->first();

        $this->organizationDetail->parent_id = $latestOrganizationDetail?->id;
        $this->organizationDetail->map_apply_id = $this->mapApply->id;
        $this->organizationDetail->status = 'pending';

        $organization = Organization::where('id',  $this->organizationDetail->organization_id)->first();
        $this->organizationDetail->name = $organization->org_name_ne;
        $this->organizationDetail->contact_no = $organization->org_contact;
        $this->organizationDetail->email = $organization->org_email;


        $dto = OrganizationDetailDto::fromLiveWireModel($this->organizationDetail);
          $service = new OrganizationDetailService();
     
        try{
            $service->store($dto);
           
            $this->successFlash(__('ebps::ebps.application_updated_successfully'));
            return redirect()->route('admin.ebps.map_applies.show-organization-template', ['organizationId' => $organization->id, 'mapApplyId' => $this->mapApply->id]);
           
        }  catch (\Exception $e) {
            logger($e);
           
            $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
        }

    }

    private function storeDocumentFiles(int $mapApplyId, array $files, $mapDocuments, int $houseOwnerId): void
    {
        foreach ($files as $index => $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $storedFilePath = $this->processFiles($file);
                DocumentFile::create([
                    'map_apply_id' => $mapApplyId,
                    'title' => $mapDocuments[$index]->title,
                    'file' => $storedFilePath,
                    'document_type' => DocumentTypeEnum::ORGANIZATION_CHANGE->value,
                    'house_owner_id' => $houseOwnerId,
                ]);

            }
        }
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
