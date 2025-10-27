<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\ComplaintRegistrationsExport;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Service\ComplaintRegistrationAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Src\Wards\Models\Ward;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use Src\Settings\Traits\AdminSettings;
use Carbon\Carbon;
use Src\Ejalas\Enum\ApplicationStatus;
use Src\Ejalas\Enum\RouteName;

class ComplaintRegistrationTable extends DataTableComponent
{
    use SessionFlash, HelperDate, AdminSettings;
    protected $model = ComplaintRegistration::class;
    //for report
    public $report = false;
    public $startDate = null;
    public $endDate = null;
    public $from;
    public $status = null;
    public $disputeMatter = null;
    public $disputeArea = null;
    public $reconciliationCenter = null;
    public $ward = null;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    // protected $listeners = ['getSearchDate' => 'getSearchDate', 'print-complaint' => 'downloadPdf'];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_complaint_registrations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_complaint_registrations.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            // ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function mount($report = false, $from = null)  // Default to false if not passed
    {
        $this->report = $report;
        $this->from = $from;
    }
    public function builder(): Builder
    {
        return ComplaintRegistration::query()
            ->select(
                'fiscal_year_id',
                'reg_no',
                'old_reg_no',
                'reg_date',
                'reg_address',
                'complainer_id',
                'defender_id',
                'priority_id',
                'dispute_matter_id',
                'subject',
                'description',
                'claim_request',
                'status',
                'ward_no',
            )
            ->with(['fiscalYear', 'priority', 'disputeMatter', 'parties', 'disputeMatter.disputeArea'])
            ->where('jms_complaint_registrations.deleted_at', null)
            ->where('jms_complaint_registrations.deleted_by', null)
            ->orderBy('jms_complaint_registrations.created_at', 'DESC');
    }
    // public function getSearchDate($startDate, $endDate, $selectedStatus, $selectedDisputeMatter, $selectedDisputeArea, $selectedReconciliationCenter, $selectedWard)
    // {
    //     $this->startDate = $startDate;
    //     $this->endDate = $endDate;
    //     $this->status = $selectedStatus;
    //     $this->disputeMatter = $selectedDisputeMatter;
    //     $this->disputeArea = $selectedDisputeArea;
    //     $this->reconciliationCenter = $selectedReconciliationCenter;
    //     $this->ward = $selectedWard;
    // }

    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.registration_details'))
                ->label(function ($row) {
                    return (string) view('Ejalas::livewire.table.complaint-registration.complaint-registration-time', [
                        'fiscalYearId' => $row->fiscalYear->year ?? 'N/A',
                        'regNo' => $row->reg_no ?? 'N/A',
                        'regDate' => $row->reg_date,
                    ]);
                })
                ->html()
                ->sortable()
                ->collapseOnTablet()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('fiscalYear', function ($query) use ($term) {
                        $query->where('year', 'like', "%{$term}%");
                    })
                        ->orWhere('reg_no', 'like', "%{$term}%")
                        ->orWhere('reg_date', 'like', "%{$term}%");
                    // ->orWhereRaw('DATE(reg_date) like ?', ["%{$term}%"]);
                }),

            Column::make(__('ejalas::ejalas.parties'))
                ->label(function ($row) {
                    // Fetch related parties using the many-to-many relationship
                    $defenders = $row->defenders->pluck('name')->toArray();
                    $complainers = $row->complainers->pluck('name')->toArray();

                    return (string) view('Ejalas::livewire.table.complaint-registration.complaint-registration-parties', [
                        'defenders' => $defenders,
                        'complainers' => $complainers,
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('parties', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%");
                    });
                })

                ->collapseOnTablet(),

            // Column::make(__('ejalas::ejalas.ward'))
            //     ->label(function ($row) {
            //         $firstComplainer = $row->parties()
            //             ->where('complaint_party.type', 'Complainer')
            //             ->first();
            //         return $firstComplainer?->permanent_ward_id
            //             ? __('ejalas::ejalas.ward') . ' ' . $firstComplainer->permanent_ward_id
            //             : '-';
            //     })
            //     ->collapseOnTablet()
            //     ->searchable()
            //     ->sortable(),

            Column::make(__('ejalas::ejalas.ward'), "ward_no")->collapseOnTablet()
                ->searchable()
                ->sortable(),

            Column::make(__('ejalas::ejalas.dispute_area'))
                ->label(fn($row) => '<div style="max-width: 90px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . e($row->disputeMatter?->disputeArea?->title ?? '-') . '">' .
                    e($row->disputeMatter?->disputeArea?->title ?? '-') .
                    '</div>')
                ->html()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.status'), "status")
                ->label(function ($row) {
                    $status = $row->status instanceof ApplicationStatus
                        ? $row->status
                        : ApplicationStatus::from($row->status);

                    // Define colors based on the enum value
                    $color = match ($status) {
                        ApplicationStatus::Accepted => 'success',
                        ApplicationStatus::Rejected => 'danger',
                        ApplicationStatus::Pending => 'warning',
                    };

                    $label = $status->label($status);


                    return '<span class="badge bg-' . $color . '">' . e($label) . '</span>';
                })
                ->html() // enables HTML rendering
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

        ];
        if (!$this->report && (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print'))) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm me-1" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                $view = '<button type="button" class="btn btn-success btn-sm me-1"  wire:click="view(' . $row->id . ')"><i class="bx bx-show"></i></button>';
                $buttons .= $view;
                $forward = '<button type="button" class="btn btn-sm me-1 text-white" 
               style="background-color: #17a2b8; color: white;"
                wire:click="forward(' . $row->id . ')">
                <i class="bx bx-right-arrow-alt"></i>
            </button>';
                $buttons .= $forward;



                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-info btn-sm me-1" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('jms_judicial_management edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.complaint_registrations.edit', [
            'id' => $id,
            'from' => $this->from,
        ]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ComplaintRegistrationAdminService();
        $service->delete(ComplaintRegistration::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.complaint_registration_deleted_successfully'));
    }
    public function view($id)
    {
        if (!can('jms_judicial_management access')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.complaint_registrations.view', [
            'id' => $id,
        ]);
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ComplaintRegistrationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ComplaintRegistrationsExport($records), 'complaint_registrations.xlsx');
    }

    public function preview($id)
    {
        return redirect()->route('admin.ejalas.complaint_registrations.preview', ['id' => $id]);
    }
    public function forward($id)
    {
        return redirect()->route('admin.ejalas.complaint_registrations.forward', ['id' => $id]);
    }
}
