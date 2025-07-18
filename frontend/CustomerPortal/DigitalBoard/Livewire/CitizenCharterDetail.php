<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;

class CitizenCharterDetail extends Component
{
    public CitizenCharter $selectedCharter;
    public $filterType = 'palika';
    public $citizenCharters = [];


    public function mount(CitizenCharter $charter)
    {
        $this->selectedCharter = $charter ?? CitizenCharter::firstOrNew([]);
        $this->citizenCharters = CitizenCharter::whereNull('deleted_at')->where('can_show_on_admin', true)->get();
        $this->filterType = 'palika';

    }

    public function isWard()
    {
        $this->filterType = 'ward';
        $this->citizenCharters = CitizenCharter::whereNull('deleted_at')
            ->where('can_show_on_admin', false)
            ->get();
    }

    public function isPalika()
    {
        $this->filterType = 'palika';
        $this->citizenCharters = CitizenCharter::whereNull('deleted_at')
            ->where('can_show_on_admin', true)
            ->get();

    }

    public function selectCharter($id)
    {
        $this->selectedCharter = CitizenCharter::findOrFail($id);

    }

    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.citizen-charter.citizen-charter-detail', [
            'selectedCharter' => $this->selectedCharter,
            'citizenCharters' => $this->citizenCharters,
            'filterType' => $this->filterType,
        ]);
    }
    
}
