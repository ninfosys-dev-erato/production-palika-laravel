<?php

namespace Src\Yojana\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDO;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\ProjectDocument;
use Illuminate\Support\Facades\Auth;


class DocumentUploadForm extends Component
{
    use SessionFlash, WithFileUploads;
    public $projectDocument;

    public Plan $plan;
    public $additonalDocuments;
    public $uploadedFiles = [];
    public $uploadedFilesUrls = [];
    public $documentName;
    public $documentFile;
    public $uploadedDocuments = [];
    protected $rules = [
        'documentName' => 'required|string|max:255',
        'documentFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];


    public function mount($plan)
    {
        $this->plan = $plan;

      
        $this->uploadedDocuments = ProjectDocument::where('plan_id', $this->plan->id)
            ->get()
            ->map(function ($doc) {
                return [
                    'name' => $doc->document_name,
                    'url' => FileFacade::getTemporaryUrl(
                        path: config('src.Yojana.yojana.evaluation'),
                        filename: $doc->data,
                        disk: getStorageDisk('private')
                    ),
                ];
            })
            ->toArray();
    }
    public function uploadDocument()
    {
    
    $this->validate();
        DB::beginTransaction();
        try {
            // Use your existing file handler
            $this->handleFileUpload(
                file: $this->documentFile,
                modelField: $this->documentName,
                urlProperty: 'tempUrl'
            );

            $this->uploadedDocuments[] = [
                'name' => $this->documentName,
                'url' => $this->tempUrl,
            ];


            DB::commit();
            $this->reset(['documentName', 'documentFile']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('documentFile', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    public function deleteDocument($index)
    {
        $doc = $this->uploadedDocuments[$index] ?? null;
        if ($doc) {
            ProjectDocument::where('plan_id', $this->plan->id)
                ->where('document_name', $doc['name'])
                ->delete();

            unset($this->uploadedDocuments[$index]);
            $this->uploadedDocuments = array_values($this->uploadedDocuments);
            $this->successToast(__('yojana::yojana.file_deleted_successfully'));
        }
    }

    public function render()
    {
        return view('Yojana::livewire.cost-estimation.document-upload-form');
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {

        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.evaluation'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );
            ProjectDocument::updateOrCreate(
                [
                    'plan_id' => $this->plan->id,
                    'document_name' => $modelField,
                ],
                [
                    'data' => $save,
                    'deleted_at' => null,
                    'deleted_by' => null,
                ]
            );

            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.evaluation'),
                filename: $save,
                disk: getStorageDisk('private')
            );
            $this->successToast(__('yojana::yojana.data_saved_successfully'));
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.evaluation'),
                    filename: $this->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }
    public function deleteFile(string $modelField)
    {
        $document = ProjectDocument::where('plan_id', $this->plan->id)
            ->where('document_name', $modelField)
            ->first();
        if ($document) {
            $document->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::user()->id,
            ]);
            $this->{$modelField} = null;
            $this->{$modelField . '_Url'} = null;

            $this->successToast(__('yojana::yojana.file_deleted_successfully'));
        } else {
            $this->errorToast(__('yojana::yojana.file_not_found'));
        }
    }

    public function save() {}
}
