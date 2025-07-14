<?php

namespace Frontend\Pwa\PwaKiosk\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\CitizenCharter;;
use Src\Wards\Models\Ward;
class PwaCitizenCharter extends Component
{
    public CitizenCharter $selectedCharter;
    public $filterType = 'palika';
    public $citizenCharters = [];
    public $ward = 0;

    public function mount($ward = 0)
    {
        $this->ward = $ward;

        // Get the maximum ward number available
        $maxWardNumber = Ward::max('id'); // Ensure 'ward' is the correct column name

        if ($this->ward > $maxWardNumber) {
            // Assign null if the ward number is out of range
            $this->selectedCharter = null;
        } else {
            // Assign the first available CitizenCharter, or a new instance if not found
            $this->selectedCharter = CitizenCharter::where('can_show_on_admin', false)
                ->whereNull(['deleted_at', 'deleted_by'])
                ->when($this->ward > 0, function ($query) {
                    return $query->whereHas('wards', function ($q) {
                        $q->where('ward', $this->ward);
                    });
                })->firstOrNew([]);

        }

        // Fetch CitizenCharters based on conditions
        $this->citizenCharters = CitizenCharter::where('can_show_on_admin', false)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($this->ward > 0, function ($query) {
                return $query->whereHas('wards', function ($q) {
                    $q->where('ward', $this->ward);
                });
            })
            ->get();
    }



    public function isWard($ward)
    {
        $this->filterType = 'ward';
//        $this->citizenCharters = CitizenCharter::whereNull('deleted_at')
//            ->where('can_show_on_admin', false)
//            ->get();

        $this->citizenCharters = CitizenCharter::where('can_show_on_admin', false)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
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
        return view('Pwa.PwaKiosk::livewire.citizen-charter', [
            'selectedCharter' => $this->selectedCharter,
            'citizenCharters' => $this->citizenCharters,
            'filterType' => $this->filterType,
        ]);
    }

}
