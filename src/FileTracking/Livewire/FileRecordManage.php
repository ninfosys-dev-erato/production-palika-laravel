<?php

namespace Src\FileTracking\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Src\Employees\Models\Branch;
use Src\FileTracking\DTO\FileRecordAdminDto;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\FileRecordAdminService;

class FileRecordManage extends Component
{
    use SessionFlash, WithPagination, WithoutUrlPagination;

    public $starredRecords;
    public $total =0;
    public $farsyautCount = 0;
    public $NoFarsyautCount = 0;
    public $archivedCount  = 0;
    public $favouriteCount  = 0;
    public string $currentPage = "file-records";
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $searchTerm = '';

    public function rules(): array
    {
        return [
            'fileRecord.reg_no' => ['required'],
            'fileRecord.subject_type' => ['required'],
            'fileRecord.subject_id' => ['required'],
        ];
    }

    public function clearSearch()
    {
        $this->reset('searchTerm'); // Reset the search term
        $this->resetPage(); // Reset pagination for all pages
        $this->fileRecordsPage = 1;
        $this->farsyautPage = 1;
        $this->archivedPage = 1;
        $this->noFarsyautPage = 1;
        $this->setActiveTab('file-records');
    }


    public function updatedSearchTerm()
    {
        $this->resetPage(); // Ensure pagination resets
        $this->setActiveTab('file-records'); // Set default tab after search
        $this->dispatch('refresh'); // Force Livewire to re-render the component
    }


    public function Search()
    {
        $this->resetPage(); // Reset pagination to the first page
        $this->fileRecordsPage = 1;
        $this->farsyautPage = 1;
        $this->archivedPage = 1;
        $this->noFarsyautPage = 1;
        $this->setActiveTab('file-records');
    }


    public function render()
    {
        $user = auth()->user()->fresh();

        if (!isset($this->currentPage)) {
            $this->currentPage = "file-records";
        }

        $query = FileRecord::whereNull('tbl_file_records.deleted_at')->with('seenFavourites');

         if (!$user->hasRole('super-admin')) {
            $userWard = GlobalFacade::ward();
            $userDepartment = GlobalFacade::department();
            
            $wardModel = is_int($userWard) ? \Src\Wards\Models\Ward::find($userWard) : $userWard;
            $departmentModel = is_int($userDepartment) ? Branch::find($userDepartment) : $userDepartment;

                $query->where(function ($q) use ($wardModel, $departmentModel) {
                    // Match if subject belongs to the ward
                    if ($wardModel) {
                        $q->whereHas('subject', fn($sq) => $sq->where('ward', $wardModel->id))
                            ->orWhere(function ($subQ) use ($wardModel) {
                                $subQ->where('recipient_type', get_class($wardModel))
                                    ->where('recipient_id', $wardModel->id);
                            });
                    }
                    // Match if recipient is the department
                    if ($departmentModel) {
                        $q->orWhere(function ($subQ) use ($departmentModel) {
                            $subQ->where('recipient_type', get_class($departmentModel))
                                ->where('recipient_id', $departmentModel->id);
                        });
                    }
                });

         }

        if (!empty(trim($this->searchTerm))) { // Trim to avoid accidental spaces
            $query->where(function ($subQuery) {
                $subQuery->where('applicant_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('applicant_mobile_no', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('reg_no', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $this->searchTerm . '%');
            });
        }


        // Count Queries - Only Executed Once
        $this->total = (clone $query)->count();
        $this->farsyautCount = (clone $query)->where('is_farsyaut', true)->count();
        $this->NoFarsyautCount = $this->total - $this->farsyautCount;

        // User-specific query
        $userSpecificQuery = FileRecord::select('tbl_file_records.*')
            ->whereNull('tbl_file_records.deleted_at')
            ->join('tbl_file_record_seen_favourites as fsf', 'tbl_file_records.id', '=', 'fsf.file_record_id')
            ->where('fsf.user_id', $user->id)
            ->with('seenFavourites');

        // Archived & Favorite Counts
        $this->archivedCount = (clone $userSpecificQuery)->where('fsf.is_archived', true)->count();
        $this->favouriteCount = (clone $userSpecificQuery)->where('fsf.is_favourite', true)->count();

        // Pagination Queries - Load only the necessary data based on the current tab
        $fileRecords = $archivedRecords = $farsyautRecords = $NoFarsyautRecords = null;

        switch ($this->currentPage) {
            case 'archived-records':
                $archivedRecords = (clone $userSpecificQuery)
                    ->where('fsf.is_archived', true)
                    ->orderBy('tbl_file_records.created_at', 'desc')
                    ->paginate(50, pageName: 'archived-records');
                break;

            case 'farsyaut-records':
                $farsyautRecords = (clone $query)
                    ->where('is_farsyaut', true)
                    ->orderBy('created_at', 'desc')
                    ->paginate(50, pageName: 'farsyaut-records');
                break;

            case 'nofarsyaut-records':
                $NoFarsyautRecords = (clone $query)
                    ->where('is_farsyaut', false)
                    ->orderBy('created_at', 'desc')
                    ->paginate(50, pageName: 'nofarsyaut-records');
                break;

            default: // file-records
                $fileRecords = (clone $query)
                    ->orderBy('created_at', 'desc')
                    ->paginate(50, pageName: 'file-records');
                break;
        }

        return view("FileTracking::livewire.file-record-manage", compact(
            'fileRecords', 'archivedRecords', 'farsyautRecords', 'NoFarsyautRecords',
        ));
    }


    public function save()
    {
        $this->validate();
        $dto = FileRecordAdminDto::fromLiveWireModel($this->fileRecord);
        $service = new FileRecordAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash( __('filetracking::filetracking.file_record_created_successfully'));
                return redirect()->route('admin.file_records.index');
                break;
            case Action::UPDATE:
                $service->update($this->fileRecord,$dto);
                $this->successFlash( __('filetracking::filetracking.file_record_updated_successfully'));
                return redirect()->route('admin.file_records.index');
                break;
            default:
                return redirect()->route('admin.file_records.index');
                break;
        }
    }

    public function updatedFileRecords($page)
    {
        $this->currentPage = "file-records";
    }

    public function updatedArchivedRecords($page)
    {
        $this->currentPage = "archived-records";
    }

    public function updatedFarsyautRecords($page)
    {
        $this->currentPage = "farsyaut-records";
    }

    public function updatedNofarsyautRecords($page)
    {
        $this->currentPage = "nofarsyaut-records";
    }

    public function updatedPaginators($page, $pageName)
    {
        $this->currentPage = $page;
    }

    public function setActiveTab($page)
    {
        $this->currentPage = $page;
    }
}
