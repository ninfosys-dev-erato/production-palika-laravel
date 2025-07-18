<?php

namespace Src\Meetings\Livewire;

use Livewire\Component;
use Src\Meetings\Models\Meeting;

class MeetingDetails extends Component
{
    public ?Meeting $meeting;
    public function mount(Meeting $meeting)
    {
       $this->meeting = $meeting;
    }

    public function render()
    {
        return view('Meetings::livewire.details');
    }
}