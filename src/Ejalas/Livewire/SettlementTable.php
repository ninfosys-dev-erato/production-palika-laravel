<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\SettlementsExport;
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Service\SettlementAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class SettlementTable extends DataTableComponent
{
    use SessionFlash, HelperDate;
    protected $model = Settlement::class;
    protected $listeners = ['getSearchDate' => 'getSearchDate'];
    public $report = false;
    public $startDate = null;
    public $endDate = null;
    public $settledStatus;
    public $from;

    public function mount($report = false, $from = null)  // Default to false if not passed
    {
        $this->report = $report;
        $this->from = $from;
    }
    public function getSearchDate($startDate, $endDate, $settledStatus)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->settledStatus = $settledStatus;
    }
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_settlements.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_settlements.id'])
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
        return Settlement::query()
            ->select('*')
            ->with(['complaintRegistration', 'judicialMember'])
            ->whereNull('jms_settlements.deleted_at')
            ->whereNull('jms_settlements.deleted_by')
            ->orderBy('jms_settlements.created_at', 'DESC')
            ->when($this->report, function ($query) {
                return $query->where('is_settled', $this->settledStatus)
                    ->whereBetween('discussion_date', [$this->startDate, $this->endDate]);
            });
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.date'))->label(function ($row) {
                return "<strong>" . (__('ejalas::ejalas.discussion_date')) . ":" . "</strong> " .
                    ($row->discussion_date ? replaceNumbers($this->adToBs($row->discussion_date), true) : "N/A") .
                    "<br><strong>" . (__('ejalas::ejalas.settlement_date')) . ":" . "</strong> " .
                    ($row->settlement_date);
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.present_members'), "judicialMember.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.settlement_details'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 200px;' title='{$row->condition}'>
                                {$row->settlement_details}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            BooleanColumn::make(__('ejalas::ejalas.is_settled'), "is_settled")->sortable()->searchable()->collapseOnTablet(),
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
                    $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
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
        return redirect()->route('admin.ejalas.settlements.edit', ['id' => $id, 'from' => $this->from,]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new SettlementAdminService();
        $service->delete(Settlement::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.settlement_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new SettlementAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new SettlementsExport($records), 'settlements.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.settlements.preview', ['id' => $id]);
    }
}
