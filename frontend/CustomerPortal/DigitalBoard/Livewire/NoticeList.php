<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use App\Traits\HelperDate;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Src\DigitalBoard\Models\Notice;

class NoticeList extends Component
{
    use WithPagination, HelperDate;

    public $localBodies = [];
    public $wards = [];
    public $ward = 'All Wards';
    public $isDropdownVisible = false;
    public $perPage = 10;
    public $search = '';
    public $start_date;
    public $end_date;
    public $isFiltered = false;

    public function mount()
    {
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function resetSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function toggleDropdown()
    {
        $this->isDropdownVisible = !$this->isDropdownVisible;
    }

    public function showAllNotices()
    {
        $this->resetPage();
        $this->ward = 'All Wards';
        $this->isDropdownVisible = false;
    }

    public function filterWard($wardId)
    {
        $this->resetPage();
        $this->ward = "Ward - $wardId";
        $this->isDropdownVisible = false;
    }

    public function searchNotices()
    {
        $this->resetPage();
    }

    public function filterDate()
    {
        $this->isFiltered = true;
        $start_date = $this->start_date ? $this->bsToAd($this->start_date) : null;
        $end_date = $this->end_date ? $this->bsToAd($this->end_date) : null;
        $startDate = Carbon::parse($start_date)->startOfDay();
        $endDate = Carbon::parse($end_date)->endOfDay();
        $this->notices = Notice::whereBetween('created_at', [$startDate, $endDate])->paginate($this->perPage);
    }

    public function resetFilter()
    {
        $this->start_date="";
        $this->end_date="";
        $this->isFiltered = false;
        $this->resetPage();
    }

    public function getNoticesProperty()
    {
        $query = Notice::whereNull('deleted_at')->where('can_show_on_admin', true);

        if ($this->ward !== 'All Wards') {
            $query->whereHas('wards', function ($subQuery) {
                $subQuery->where('ward', $this->ward);
            });
        }

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        return $query->paginate($this->perPage);
    }



    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.notice.notice-list', [
            'notices' => $this->notices,
        ]);
    }
}
