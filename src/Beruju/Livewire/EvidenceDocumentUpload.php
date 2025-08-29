<?php

namespace Src\Beruju\Livewire;

use App\Facades\FileFacade;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Traits\SessionFlash;
use Src\Beruju\Service\EvidenceService;
use Src\Beruju\DTO\EvidenceDto;
use Illuminate\Support\Facades\Auth;
use Src\Beruju\Models\Evidence;

class EvidenceDocumentUpload extends Component
{
    use WithFileUploads, SessionFlash;

    public $berujuEntryId;
    public $actionId;
    public $type;
    public $berujuAction;

    public Evidence $evidence;

    public $evidenceDocuments = [];
    public $evidenceData = [];
    public $uploadedFiles = [];
    public $uploadedFileUrls = [];
    public $savedDocuments = [];

    protected $listeners = [
        'saveAllDocumentsfunction' => 'saveAllDocuments',
        'action-updated' => 'refreshComponent',
        'load-existing-documents' => 'refreshComponent'
    ];
    


    protected $rules = [
        'evidenceData.*.name' => 'required|string|max:255',
        'evidenceData.*.description' => 'nullable|string',
        'uploadedFiles.*' => 'required',
    ];

    protected $messages = [
        'evidenceData.*.name.required' => 'Document name is required.',
        'uploadedFiles.*.required' => 'Please select a file.',
    ];

    public function mount(Evidence $evidence = null, $berujuEntry = null, $berujuAction = null, $type = null)
    {
        $this->type = $type;
        $this->berujuAction = $berujuAction;
        
        if ($evidence) {
            $this->evidence = $evidence;
        } else {
            $this->evidence = new Evidence();
        }

        if ($berujuEntry) {
            $this->berujuEntryId = $berujuEntry->id;
            $this->evidence->beruju_entry_id = $berujuEntry->id;
            
            if ($type === 'action') {
                if ($berujuAction && $berujuAction->id) {
                    $this->actionId = $berujuAction->id;
                    $this->evidence->action_id = $berujuAction->id;
                    $this->loadExistingDocuments($this->berujuEntryId, $this->actionId, $this->type);
                } else {
                    $this->addDocument();
                }
            } else {
                $this->loadExistingDocuments($this->berujuEntryId, $this->type);
            }
        } else {
            // Initialize with one empty document
            $this->addDocument();
        }
    }
    private function loadExistingDocuments($berujuEntryId, $actionId = null, $type = null)
    {
        $existingEvidences = Evidence::where('beruju_entry_id', $berujuEntryId)
            ->when($actionId, function ($query) use ($actionId) {
                $query->where('action_id', $actionId);
            })
            ->when($type === 'beruju', function ($query)  {
                $query->where('action_id', null);
            })
            ->whereNull('deleted_at')
            ->get();


        if ($existingEvidences->isEmpty()) {
            // If no existing documents, add one empty document
            $this->addDocument();
            return;
        }

        foreach ($existingEvidences as $index => $evidence) {

            $this->evidenceDocuments[] = $index;


            $this->evidenceData[$index] = [
                'name' => $evidence->name ?? '',
                'description' => $evidence->description ?? ''
            ];

            // Generate temporary preview URL for existing file
            $this->uploadedFileUrls[$index] = $evidence->evidence_document_name
                ? FileFacade::getTemporaryUrl(
                    path: config('src.Beruju.beruju.uploads'),
                    filename: $evidence->evidence_document_name,
                    disk: getStorageDisk('private')
                )
                : null;


            $this->savedDocuments[$index] = [
                'name' => $evidence->name ?? '',
                'description' => $evidence->description ?? '',
                'evidence_document_name' => $evidence->evidence_document_name ?? '',
                'is_existing' => true,
                'evidence_id' => $evidence->id
            ];

            $this->uploadedFiles[$index] = null;
        }
    }


    public function addDocument()
    {
        $index = count($this->evidenceDocuments);
        $this->evidenceDocuments[] = $index;
        $this->evidenceData[$index] = [
            'name' => '',
            'description' => ''
        ];
        $this->uploadedFiles[$index] = null;
        $this->uploadedFileUrls[$index] = null;
    }

    public function removeDocuments($index)
    {
        // Check if this is an existing document that needs to be deleted from database
        if (
            isset($this->savedDocuments[$index]['is_existing']) &&
            $this->savedDocuments[$index]['is_existing'] &&
            isset($this->savedDocuments[$index]['evidence_id'])
        ) {

            try {
                $evidenceService = new EvidenceService();
                $existingEvidence = Evidence::find($this->savedDocuments[$index]['evidence_id']);

                if ($existingEvidence) {
                    $evidenceService->delete($existingEvidence);
                    $this->successToast(__('beruju::beruju.evidence_deleted_successfully'));
                }
            } catch (\Exception $e) {
                $this->errorToast(__('beruju::beruju.failed_to_delete_evidence'));
            }
        }

        unset($this->evidenceDocuments[$index]);
        unset($this->evidenceData[$index]);
        unset($this->uploadedFiles[$index]);
        unset($this->uploadedFileUrls[$index]);
        unset($this->savedDocuments[$index]);

        // Reindex arrays
        $this->evidenceDocuments = array_values($this->evidenceDocuments);
        $this->evidenceData = array_values($this->evidenceData);
        $this->uploadedFiles = array_values($this->uploadedFiles);
        $this->uploadedFileUrls = array_values($this->uploadedFileUrls);
        $this->savedDocuments = array_values($this->savedDocuments);
    }

    private function handleFileUploadForDocument($file)
    {
        $savedFileName = FileFacade::saveFile(
            path: config('src.Beruju.beruju.uploads'),
            file: $file,
            disk: getStorageDisk('private'),
            filename: ""
        );

        $tempUrl = FileFacade::getTemporaryUrl(
            path: config('src.Beruju.beruju.uploads'),
            filename: $savedFileName,
            disk: getStorageDisk('private')
        );

        return [$savedFileName, $tempUrl];
    }

    public function updatedUploadedFiles($value, $key)
{
    // $key will be like "0", "1", etc. depending on $index
    $index = $key;

    $this->saveDocuments($index);
}

    public function saveDocuments($index)
    {

        $this->validate([
            // "evidenceData.{$index}.name" => 'required|string|max:255',
            // "evidenceData.{$index}.description" => 'nullable|string',
            "uploadedFiles.{$index}" => 'required',
        ]);
       

        try {
            $file = $this->uploadedFiles[$index] ?? null;
            // dd($this->uploadedFiles,$file);

            if ($file) {

                [$savedFileName, $tempUrl] = $this->handleFileUploadForDocument($file);

                $this->savedDocuments[$index] = [
                    'name' => $this->evidenceData[$index]['name'] ?? '',
                    'description' => $this->evidenceData[$index]['description'] ?? '',
                    'evidence_document_name' => $savedFileName,
                ];

                $this->uploadedFileUrls[$index] = $tempUrl;

                $this->successToast(__('beruju::beruju.evidence_added_successfully'));
            }
        } catch (\Exception $e) {
            $this->errorToast(__('beruju::beruju.failed_to_add_evidence'));
        }
    }

    public function render()
    {
        // Debug: Log the berujuAction to see what's available
        if ($this->berujuAction) {
            \Log::info('EvidenceDocumentUpload - berujuAction:', [
                'id' => $this->berujuAction->id ?? 'null',
                'attributes' => $this->berujuAction->getAttributes(),
                'type' => $this->type,
                'berujuEntryId' => $this->berujuEntryId,
                'actionId' => $this->actionId ?? 'null'
            ]);
        }
        
        return view('Beruju::livewire.evidence-document-upload');
    }

    public function saveAllDocuments($berujuEntryId = null, $berujuActionId = null)
    {
        if (empty($this->savedDocuments)) {
            return; // No documents to save
        }

        if (!$berujuEntryId) {
            $this->errorToast(__('beruju::beruju.beruju_id_is_required'));
            return;
        }

        try {
            $evidenceService = new EvidenceService();

            foreach ($this->savedDocuments as $document) {
                $evidenceDto = EvidenceDto::fromArray([
                    'beruju_entry_id' => $berujuEntryId, // Use the passed parameter
                    'action_id' => $berujuActionId ?? null,
                    'name' => $document['name'] ?? null,
                    'description' => $document['description'] ?? null,
                    'evidence_document_name' => $document['evidence_document_name'] ?? null,
                ]);


                if (!empty($document['is_existing']) && !empty($document['evidence_id'])) {
                    $existingEvidence = Evidence::find($document['evidence_id']);
                    if ($existingEvidence) {
                        $evidenceService->update($existingEvidence, $evidenceDto);
                    }
                } else {
                    $evidenceService->store($evidenceDto);
                }
            }

            $this->successToast(__('beruju::beruju.evidence_added_successfully'));
            $this->resetDocuments();
        } catch (\Exception $e) {
            $this->errorToast(__('beruju::beruju.failed_to_add_evidence') . ': ' . $e->getMessage());
        }
    }

    public function resetDocuments()
    {
        $this->evidenceDocuments = [];
        $this->evidenceData = [];
        $this->uploadedFiles = [];
        $this->uploadedFileUrls = [];
        $this->savedDocuments = [];
        $this->addDocument(); // Add one empty document
    }
    
    public function refreshComponent()
    {
        // When action data changes, reload existing documents if this is for an action
        if ($this->type === 'action' && $this->berujuAction && $this->berujuAction->id) {
            $this->actionId = $this->berujuAction->id;
            $this->evidence->action_id = $this->berujuAction->id;
            
            // Clear existing data and reload
            $this->evidenceDocuments = [];
            $this->evidenceData = [];
            $this->uploadedFiles = [];
            $this->uploadedFileUrls = [];
            $this->savedDocuments = [];
            
            $this->loadExistingDocuments($this->berujuEntryId, $this->actionId);
        }
    }
    

}
