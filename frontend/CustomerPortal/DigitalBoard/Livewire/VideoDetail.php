<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Video;

class VideoDetail extends Component
{
    public Video $selectedVideo;
    public $filterType = 'palika';
    public $latestVideos = [];


    public function mount(VIdeo $video)
    {
        $this->selectedVideo = $video; 
        $this->latestVideos = Video::whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->get(); 

        $this->filterType = 'palika';

    }

    public function showVideoDetail($id)
    {
       
        $this->selectedVideo = VIdeo::find($id);
    }

    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.video.video-detail', [
            'selectedVideo' => $this->selectedVideo,
            'latestVideos' => $this->latestVideos,
            'filterType' => $this->filterType,
        ]);
    }
    
}
