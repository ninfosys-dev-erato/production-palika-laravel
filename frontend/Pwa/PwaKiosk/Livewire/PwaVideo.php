<?php

namespace Frontend\Pwa\PwaKiosk\Livewire;

use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Src\DigitalBoard\Models\Video;

class PwaVideo extends Component
{

    public Collection $videos;
    use HelperDate;
    public $start_date;
    public $end_date;
    public int $ward;
    public $isFiltered = false;

    public function mount($ward = 0)
    {
        $this->videos = Video::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->get();

        // Ensure $selectedVideo is properly initialized
        $this->selectedVideo = $this->videos->first() ?? new Video();
    }
    public function filterDate()
    {
        $this->isFiltered = true;
        $start_date = $this->start_date ? $this->bsToAd($this->start_date) : null;
        $end_date = $this->end_date ? $this->bsToAd($this->end_date) : null;
        $startDate = Carbon::parse($start_date)->startOfDay();
        $endDate = Carbon::parse($end_date)->endOfDay();
        $this->videos = Video::whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function render()
    {
        return view("Pwa.PwaKiosk::livewire.video");
    }
}
