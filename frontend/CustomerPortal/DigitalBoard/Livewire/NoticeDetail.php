<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;

class NoticeDetail extends Component
{
    public Notice $selectedNotice;
    public $filterType = 'palika';
    public $latestNotices = [];


    public function mount(Notice $notice)
    {
        $this->selectedNotice = $notice; 
        $this->latestNotices = Notice::whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get(); 

        $this->filterType = 'palika';

    }

    public function showNoticeDetail($id)
    {
       
        $this->selectedNotice = Notice::find($id);
    }

    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.notice.notice-detail', [
            'selectedNotice' => $this->selectedNotice,
            'latestNotices' => $this->latestNotices,
            'filterType' => $this->filterType,
        ]);
    }
    
}
