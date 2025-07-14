<?php

namespace Frontend\Pwa\PwaKiosk\Livewire;

use Livewire\Component;
use Src\DigitalBoard\Models\Notice;
use App\Traits\HelperDate;
use Carbon\Carbon;
use  Illuminate\Database\Eloquent\Collection;


class PwaNotice extends Component
{
    use HelperDate;

    public Collection $notices;
    
    public int $ward;

    public $localBodies = [];

    public $wards = [];

    public $isDropdownVisible = false;

    public $perPage = 10;

    public $search = '';

    public $start_date;

    public $end_date;

    public $isFiltered = false;

    public function mount( $ward = 0)
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;

        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();
    }
    public function filterDate()
    {
        $this->isFiltered = true;
        $start_date = $this->start_date ? $this->bsToAd($this->start_date) : null;
        $end_date = $this->end_date ? $this->bsToAd($this->end_date) : null;
        $startDate = Carbon::parse($start_date)->startOfDay();
        $endDate = Carbon::parse($end_date)->endOfDay();
        $this->notices = Notice::whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function render()
    {
        return view("Pwa.PwaKiosk::livewire.notice");
    }
}
