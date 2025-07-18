<?php

namespace Src\FileTracking\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Src\FileTracking\Models\FileRecord;

class FileStarred extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '';

    public function render()
    {
        $query = FileRecord::whereHas('seenFavourites', function ($subQuery) {
            $subQuery->where('is_favourite', true)
                ->where('user_id', auth()->user()->fresh()->id)
                ->whereNull('deleted_at');
        })
            ->with('seenFavourites');

        if (!empty(trim($this->searchTerm))) { // Trim to avoid accidental spaces
            $query->where(function ($subQuery) {
                $subQuery->where('applicant_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('applicant_mobile_no', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('reg_no', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $fileRecords = $query->orderBy('created_at', 'desc')->paginate(50);

        return view("FileTracking::livewire.file-record-starred", [
            'fileRecords' => $fileRecords,
        ]);
    }

    public function clearSearch()
    {
        $this->reset('searchTerm'); // Reset the search term
        $this->resetPage(); // Reset pagination for all pages
    }

    public function Search()
    {
        $this->resetPage(); // Reset pagination to the first page

    }

}
