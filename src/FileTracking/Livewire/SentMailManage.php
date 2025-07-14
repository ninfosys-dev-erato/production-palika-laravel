<?php

namespace Src\FileTracking\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Src\FileTracking\Models\FileRecord;

class SentMailManage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '';

    public function render()
    {
        $userId = Auth::id();
        $query = FileRecord::where('sender_id', $userId)
            ->whereNull('deleted_at')
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
        
        return view("FileTracking::livewire.sent-mail-manage", compact('fileRecords'));
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
