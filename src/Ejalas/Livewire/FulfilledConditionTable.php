<?php

namespace Src\Ejalas\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\FulfilledConditionsExport;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Service\FulfilledConditionAdminService;

class FulfilledConditionTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = FulfilledCondition::class;
    public $report = false;
    public $startDate = null;
    public $endDate = null;
    public $from;
    protected $listeners = ['getSearchDate' => 'getSearchDate'];
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_fulfilled_conditions.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_fulfilled_conditions.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function mount($from = null)
    {
        $this->from = $from;
    }
    public function builder(): Builder
    {
        return FulfilledCondition::query()
            ->with('complaintRegistration', 'party', 'judicialEmployee', 'SettlementDetail')
            ->select('*')
            ->where('jms_fulfilled_conditions.deleted_at', null)
            ->where('jms_fulfilled_conditions.deleted_by', null)
            ->orderBy('jms_fulfilled_conditions.created_at', 'DESC')
            ->when($this->report, function ($query) {
                $query->whereBetween('entry_date', [$this->startDate, $this->endDate]);
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
            Column::make(__('ejalas::ejalas.complaint_details'))->label(function ($row) {
                $complaintRegistration = $row->complaintRegistration->reg_no;
                $fulfillingParty = $row->party->name;
                return "
                <strong>" . (__('ejalas::ejalas.registration_no')) . ":" . "</strong> {$complaintRegistration} <br>
                <strong>" . (__('ejalas::ejalas.fulfilling_party')) . ":" . "</strong> {$fulfillingParty} 
                ";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.completion_details'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 200px;' title='{$row->condition}'>
                                {$row->completion_details}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.fulfilled_condition_detail'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 200px;' title='{$row->condition}'>
                                {$row->SettlementDetail->detail}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.completion_proof'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 200px;' title='{$row->condition}'>
                                    {$row->completion_proof}
                                </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),


            // Column::make(__('ejalas::ejalas.completion_details'), "completion_details")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.completion_proof'), "completion_proof")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.dates'))->label(function ($row) {
                $dueDate = $row->due_date ? $row->due_date : 'N/A';
                $completionDate = $row->completion_date ? $row->completion_date : 'N/A';
                return "
                <strong>" . (__('ejalas::ejalas.condition_due_date')) . ":" . "</strong> {$dueDate} <br>
                <strong>" . (__('ejalas::ejalas.condition_completion_date')) . ":" . "</strong> {$completionDate} 
                ";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.entry_details'))->label(function ($row) {
                $enteredBy = $row->judicialEmployee->name ?? 'N/A';
                $entryDate = $row->entry_date ? replaceNumbers($this->adToBs($row->entry_date), true) : 'N/A';


                return "
                    <strong>" . (__('ejalas::ejalas.entered_by')) . ":" . "</strong> {$enteredBy} <br>
                    <strong>" . (__('ejalas::ejalas.entry_date')) . ":" . "</strong> {$entryDate} 
                    ";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

        ];
        if (!$this->report && (can('fulfilled_conditions edit') || can('fulfilled_conditions delete'))) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('fulfilled_conditions edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('fulfilled_conditions delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }
                // if (can('fulfilled_conditions print')) {
                //     $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                //     $buttons .= $preview;
                // }
                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('fulfilled_conditions edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.fulfilled_conditions.edit', ['id' => $id, 'from' => $this->from]);
    }
    public function delete($id)
    {
        if (!can('fulfilled_conditions delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FulfilledConditionAdminService();
        $service->delete(FulfilledCondition::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.fulfilled_condition_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('fulfilled_conditions delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FulfilledConditionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FulfilledConditionsExport($records), 'fulfilled_conditions.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.fulfilled_conditions.preview', ['id' => $id]);
    }
}
