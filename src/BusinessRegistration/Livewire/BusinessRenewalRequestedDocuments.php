<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Collection;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRenewalDocumentAdminDto;
use Src\BusinessRegistration\Enums\BusinessDocumentStatusEnum;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;
use Src\BusinessRegistration\Service\BusinessRenewalDocumentAdminService;

class BusinessRenewalRequestedDocuments extends Component
{

    use SessionFlash, WithFileUploads;
    public ?BusinessRenewal $businessRenewal;
    #[Modelable]
    public  $documents = [];
    public  $options = [];

    public function rules(): array
    {
        return [
            'documents.*.document_name' => ['required'],
            'documents.*.document_status' => ['required'],
            'documents.*.document' => ['nullable'],
            'documents.*.url' => ['nullable'],
        ];
    }
    public function render()
    {
        return view('BusinessRegistration::livewire.renewal.documents');
    }

    public function mount(BusinessRenewal $businessRenewal)
    {
        $this->businessRenewal = $businessRenewal;
        $this->options = BusinessDocumentStatusEnum::getForWeb();
        $this->documents = BusinessRenewalDocument::where(
            'business_renewal',
            $this->businessRenewal->id
        )->whereNull('deleted_at')->whereNull('deleted_by')->get()->map(function ($document) {
            return array_merge($document->toArray(), [
                'url' => $document->url,
            ]);
        })
            ->toArray();
    }
    public function updated($propertyName, $value)
    {
        // Check if the property being updated is a file input
        if (preg_match('/^documents\.\d+\.document$/', $propertyName)) {
            $index = (int) filter_var($propertyName, FILTER_SANITIZE_NUMBER_INT);
            // Call the fileUpload method with the relevant index
            $this->fileUpload($index);
        }
    }
    public function addDocument(): void
    {
        $this->documents[] = [
            'document_name' => null,
            'document_status' => null,
            'document' => null,
        ];
        $this->successToast(__('businessregistration::businessregistration.document_added_successfully'));
    }

    public function removeDocument(int $index): void
    {
        unset($this->documents[$index]);
        $this->successToast(__('businessregistration::businessregistration.document_successfully_removed'));
    }

    public function copyToTemp($index)
    {
        if ($this->documents[$index]['id']) {
            //Copy to Local Temp just in case user decides to toggle is_public
            FileFacade::copyFile(
                sourcePath: config('src.BusinessRegistration.businessRegistration.registration_document'),
                sourceFilename: $this->documents[$index]['document'],
                destinationPath: config('src.BusinessRegistration.businessRegistration.registration_document'),
                destinationFilename: null,
                destinationDisk: getStorageDisk('private'),
                sourceDisk: 'public',
            );
            unset($this->documents[$index]['id']);
        }
    }
    public function fileUpload($index)
    {
        $save = FileFacade::saveFile(
            path: config('src.BusinessRegistration.businessRegistration.registration_document'),
            file: $this->documents[$index]['document'],
                            disk: getStorageDisk('private'),
            filename: ""
        );
        $this->documents[$index]['document'] = $save;
        $this->documents[$index]['document_status'] = BusinessDocumentStatusEnum::UPLOADED->value;
        $this->documents[$index]['url'] = FileFacade::getTemporaryUrl(
            path: config('src.BusinessRegistration.businessRegistration.registration_document'),
            filename: $save,
                            disk: getStorageDisk('private')
        );
        // ✅ Force Livewire to recognize the change
        $this->documents = array_values($this->documents);
    }

    public function refresh()
    {
        if ($this->documents) {
            $this->documents =  BusinessRenewalDocument::where(
                'business_renewal',
                $this->businessRenewal->id
            )->whereNull('deleted_at')->whereNull('deleted_by')->get()->map(function ($document) {
                return array_merge($document->toArray(), [
                    'url' => $document->url,
                ]);
            })
                ->toArray();
        }
    }


    public function save(int $index)
    {
        $service  = new BusinessRenewalDocumentAdminService();
        $dto = BusinessRenewalDocumentAdminDto::fromLiveWireArray($this->documents[$index], $this->businessRenewal);
        $result =  $service->saveDocument($this->documents[$index]['id'] ?? 0, $dto);
        if ($result) {
            $this->successToast(__('businessregistration::businessregistration.document_saved_successfully'));
            $this->refresh(); // Refresh the documents list after saving
        } else {
            $this->errorToast(__('businessregistration::businessregistration.document_saving_failed'));
        }
    }
}
