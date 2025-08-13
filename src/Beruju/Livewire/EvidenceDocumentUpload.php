<?php

namespace Src\Beruju\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Traits\SessionFlash;

class EvidenceDocumentUpload extends Component
{
    use WithFileUploads, SessionFlash;

    public $berujuEntryId;
    public $evidences = [];
    public $newEvidence = [
        'name' => '',
        'file' => null,
        'description' => ''
    ];


    protected $rules = [
        'newEvidence.name' => 'required|string|max:255',
        'newEvidence.file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        'newEvidence.description' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'newEvidence.name.required' => 'Evidence name is required.',
        'newEvidence.file.required' => 'Please select a file.',
        'newEvidence.file.mimes' => 'File must be PDF, DOC, DOCX, JPG, JPEG, or PNG.',
        'newEvidence.file.max' => 'File size must not exceed 10MB.',
    ];

    public function mount($berujuEntryId = null)
    {
        $this->berujuEntryId = $berujuEntryId;
        $this->loadEvidences();
    }

    public function loadEvidences()
    {
        // Load existing evidences from database
        // This will be implemented when you have the evidence model
        $this->evidences = [];
    }

    public function addEvidence()
    {
        $this->showAddForm = true;
        $this->resetNewEvidence();
    }

    public function cancelAdd()
    {
        $this->showAddForm = false;
        $this->resetNewEvidence();
    }

    public function resetNewEvidence()
    {
        $this->newEvidence = [
            'name' => '',
            'file' => null,
            'description' => ''
        ];
    }



    public function render()
    {
        return view('Beruju::livewire.evidence-document-upload');
    }
}
