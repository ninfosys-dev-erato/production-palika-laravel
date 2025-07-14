<?php

namespace Src\FileTracking\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\FileTracking\DTO\SeenFavouriteDto;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\SeenFavourite;
use Src\FileTracking\Service\SeenFavouriteAdminService;

class FileRecordInbox extends Component
{
    use SessionFlash, WithFileUploads;

    public $openModalForward = false;
    public $openModalFarsyaut = false;

    public FileRecord $fileRecord;
    public SeenFavourite $seenFavourite;

    public function mount(FileRecord $fileRecord)
    {
        $fileRecord->load('sender', 'logs', 'mainThreadLogs','subject');
        $this->fileRecord = $fileRecord;
    }

    public function archieveFile()
    {
        if ($this->fileRecord->seenFavourites) {
            $seenFavourite = $this->fileRecord->seenFavourites;
            $seenFavourite->is_archived = !$seenFavourite->is_archived;
            $seenFavourite->save();
        } else {
            $seenFavourite = new SeenFavourite([
                'file_record_id' => $this->fileRecord->id,
                'user_id' => auth()->id(),
                'user_type' => get_class(Auth::guard('web')->user()),
                'is_archived' => true,
            ]);
            $seenFavourite->save();
        }
        

        $this->successFlash( __('filetracking::filetracking.file_archived_successfully'));
        return redirect()->route('admin.file_records.inbox', ['id' => $this->fileRecord->id]);


    }


    public function openModalForForward()
    {
        $this->openModalForward = !$this->openModalForward;

    }
    public function openModalForFarsyaut()
    {
        $this->openModalFarsyaut = !$this->openModalFarsyaut;
    }

    #[On('partrachar-forward-complete')]
    public function closeModalForward()
    {
        $this->openModalForward = !$this->openModalForward;

    }

    #[On('partrachar-farsyaut-complete')]
    public function closeModalFarsyaut()
    {
        $this->openModalFarsyaut = !$this->openModalFarsyaut;

    }

    public function render()
    {
        return view("FileTracking::livewire.inbox");
    }


}
