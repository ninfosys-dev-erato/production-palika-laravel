<?php

namespace Src\Ebps\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\Enums\DocumentStatusEnum;
use Src\Ebps\Models\DocumentFile;

class MapApplyDocumentUploader extends Component
{
    use WithFileUploads, SessionFlash;

    public int $mapApplyId;
    public bool $open = false;
    public ?string $title = null;
    public $document = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'max:2048'],
        ];
    }

    public function openModal(): void
    {
        $this->resetValidation();
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function save(): void
    {
        $this->validate();
        $storedPath = FileFacade::saveFile(
            path: config('src.Ebps.ebps.path'),
            filename: '',
            file: $this->document,
            disk: getStorageDisk('private'),
        );

        DocumentFile::create([
            'map_apply_id' => $this->mapApplyId,
            'title' => $this->title,
            'file' => $storedPath,
            'status' => DocumentStatusEnum::UPLOADED,
        ]);
       
        // Reset form fields
        $this->reset(['title', 'document']);
        $this->open = false;
        $this->successFlash(__('Document uploaded successfully.'));

        $this->dispatch('document-uploaded');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('Ebps::livewire.map-apply-document-uploader');
    }
}
