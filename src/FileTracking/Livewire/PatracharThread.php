<?php

namespace Src\FileTracking\Livewire;

use Livewire\Component;
use Src\FileTracking\Models\FileRecordLog;

class PatracharThread extends Component
{
    public FileRecordLog $fileRecordLog;

    public function mount(FileRecordLog $fileRecordLog)
    {
        $this->fileRecordLog = $fileRecordLog->load(['sender', 'receiver']);
    }

    public function render()
    {
        return view('FileTracking::livewire.patrachar-thread', [
            'log' => $this->fileRecordLog
        ]);
    }
}