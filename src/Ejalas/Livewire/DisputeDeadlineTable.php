<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\DisputeDeadlinesExport;
use Src\Ejalas\Models\DisputeDeadline;
use Src\Ejalas\Service\DisputeDeadlineAdminService;

class DisputeDeadlineTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = DisputeDeadline::class;
    public $report = false;
    public $startDate = null;
    public $endDate = null;
    protected $listeners = ['getSearchDate' => 'getSearchDate'];

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function mount($report = false)  // Default to false if not passed
    {
        $this->report = $report;
    }
    public function configure(): void
    {
        $this->setPrimaryKey('jms_dispute_deadlines.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_dispute_deadlines.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return DisputeDeadline::query()
            ->select('*')
            ->with(['complaintRegistration.parties', 'complaintRegistration.disputeMatter', 'complaintRegistration', 'judicialMember'])
            ->where('jms_dispute_deadlines.deleted_at', null)
            ->where('jms_dispute_deadlines.deleted_by', null)
            ->orderBy('jms_dispute_deadlines.created_at', 'DESC')
            ->when($this->report, function ($query) {
                $query->whereBetween('deadline_set_date', [$this->startDate, $this->endDate]);
            });
    }
    public function getSearchDate($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.deadline_details'))
                ->label(function ($row) {
                    $deadlineSetDate = $row->deadline_set_date
                        ? replaceNumbers($this->adToBs($row->deadline_set_date), true)
                        : 'N/A';

                    $extensionPeriod = $row->deadline_extension_period ?? 'N/A';
                    $registrar = $row->judicialMember->title ?? 'N/A';

                    return "<div>
                            <strong>" . __('ejalas::ejalas.set_date') . ":</strong> {$deadlineSetDate}<br>
                            <strong>" . __('ejalas::ejalas.extension') . ":</strong> {$extensionPeriod}<br>
                            <strong>" . __('ejalas::ejalas.registrar') . ":</strong> {$registrar}<br>
                        </div>";
                })
                ->html() // allow HTML rendering
                ->collapseOnTablet()
                ->sortable(),
            Column::make(__('ejalas::ejalas.complainer'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Complainer')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),

            Column::make(__('ejalas::ejalas.defender'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Defender')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),


            Column::make(__('ejalas::ejalas.dispute_subject'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 100px;' title='{$row->complaintRegistration->disputeMatter->title}'>
                                    {$row->complaintRegistration->disputeMatter->title}
                                </div>";
            })->html()
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
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
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
        return redirect()->route('admin.ejalas.dispute_deadlines.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeDeadlineAdminService();
        $service->delete(DisputeDeadline::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.dispute_deadline_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DisputeDeadlineAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DisputeDeadlinesExport($records), 'dispute_deadlines.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.dispute_deadlines.preview', ['id' => $id]);
    }
}
