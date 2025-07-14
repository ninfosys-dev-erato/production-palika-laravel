<?php

namespace Src\FileTracking\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\SeenFavouriteAdminService;

class FileRecordManageRow extends Component
{
    use SessionFlash;
    #[Modelable]
    public ?FileRecord $fileRecord;
    public function mount(FileRecord $fileRecord){
        $this->fileRecord = $fileRecord;
    }

    public function render(){
        return view('FileTracking::livewire.file-record-manage-row');
    }

    public function toggleFavourite(FileRecord $fileRecord){
        $seenFavouriteService = new SeenFavouriteAdminService();
       $status = $seenFavouriteService->toggleFavourite($fileRecord,auth()->user()->fresh());
       $this->fileRecord->refresh();
       if ($status){
           $this->successToast(__('filetracking::filetracking.added_to_favourites'));
       }else{
           $this->warningToast(__('filetracking::filetracking.removed_from_favourites'));
       }
       return true;
    }
    public function goToFileRecord($id)
    {
        return redirect()->route('admin.file_records.inbox', ['id' => $id]);
    }
}
