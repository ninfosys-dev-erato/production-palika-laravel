<?php

namespace Frontend\CustomerPortal\DigitalBoard\Livewire;

use App\Traits\HelperDate;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Src\DigitalBoard\Models\Program;

class ProgramList extends Component
{
    use WithPagination, HelperDate;
    public Program $program;
    public $filterType = 'palika';
    public $wards = [];
    public $ward = 'All Wards';
    public $wardId;
    public $isDropdownVisible = false;
    public $perPage = 10;
    public $search = '';

    public $start_date;
    public $end_date;
    public $isFiltered = false;


    public function mount(Program $program)
    {
        $this->filterType = 'palika';
        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }

    public function getProgramsProperty()
    {
        $query = Program::whereNull('deleted_at');

        if ($this->filterType === 'ward') {
            $query->where('can_show_on_admin', false);
        } else {
            $query->where('can_show_on_admin', true);
        }
        if ($this->ward !== 'All Wards') {
            $query->whereHas('wards', function ($subQuery) {
                $subQuery->where('ward', $this->wardId);
            });
        }

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        return $query->paginate($this->perPage);
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

    public function filterWard($wardId)
    {
        $this->resetPage();
        $this->ward = "Ward - $wardId";
        $this->wardId = $wardId;
        $this->isDropdownVisible = false;
    }

    public function toggleDropdown()
    {
        $this->isDropdownVisible = !$this->isDropdownVisible;
    }

    public function showAllPrograms()
    {
        $this->resetPage();
        $this->ward = 'All Wards';
        $this->isDropdownVisible = false;
    }

    public function searchPrograms()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->start_date="";
        $this->end_date="";
        $this->isFiltered = false;
        $this->resetPage();
    }

    public function filterDate()
    {
        $this->isFiltered = true;
        $start_date = $this->bsToAd($this->start_date);
        $end_date = $this->bsToAd($this->end_date);
        $startDate = Carbon::parse($start_date)->startOfDay();
        $endDate = Carbon::parse($end_date)->endOfDay();

        $this->resetPage();
        $this->programs = Program::whereBetween('created_at', [$startDate, $endDate])
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('CustomerPortal.DigitalBoard::livewire.program.program-list', [
            'programs' => $this->programs,
            'filterType' => $this->filterType,
        ]);
    }
}
