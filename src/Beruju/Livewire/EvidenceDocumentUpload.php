<?php

namespace Src\Beruju\Livewire;

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

    public Evidence $evidence;

    protected $rules = [
        'evidence.beruju_entry_id' => 'required|string',
        'evidence.name' => 'required|string|max:255',
        'evidence.file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        'evidence.description' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'evidence.name.required' => 'Evidence name is required.',
        'evidence.file.required' => 'Please select a file.',
        'evidence.file.mimes' => 'File must be PDF, DOC, DOCX, JPG, JPEG, or PNG.',
        'evidence.file.max' => 'File size must not exceed 10MB.',
    ];

    public function mount(Evidence $evidence = null, $berujuEntryId = null)
    {
        if ($evidence) {
            $this->evidence = $evidence;
        } else {
            $this->evidence = new Evidence();
        }

        if ($berujuEntryId) {
            $this->berujuEntryId = $berujuEntryId;
            $this->evidence->beruju_entry_id = $berujuEntryId;
        }
    }

    public function saveEvidence()
    {
        $this->validate();

        try {
            // Handle file upload if file is present
            if ($this->evidence->file) {
                $fileName = time() . '_' . uniqid() . '.' . $this->evidence->file->getClientOriginalExtension();
                $filePath = $this->evidence->file->storeAs('beruju/evidences', $fileName, 'public');

                $this->evidence->file_name = $this->evidence->file->getClientOriginalName();
                $this->evidence->file_path = $filePath;
                $this->evidence->file_size = $this->evidence->file->getSize();
                $this->evidence->file_type = $this->evidence->file->getClientMimeType();
            }

            $this->evidence->created_by = Auth::id();
            $this->evidence->save();

            $this->showSuccessMessage(__('beruju::beruju.evidence_added_successfully'));
            $this->resetForm();
        } catch (\Exception $e) {
            $this->showErrorMessage(__('beruju::beruju.failed_to_add_evidence'));
        }
    }

    public function resetForm()
    {
        $this->evidence = new Evidence();
    }





    public function render()
    {
        return view('Beruju::livewire.evidence-document-upload');
    }
}
