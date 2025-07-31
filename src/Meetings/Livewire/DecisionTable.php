<?php

namespace Src\Meetings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Meetings\Exports\DecisionsExport;
use Src\Meetings\Models\Decision;
use Src\Meetings\Service\DecisionAdminService;

class DecisionTable extends DataTableComponent
{
    use SessionFlash;

    public ?int $meetingId;
    protected $model = Decision::class;

    public function mount(int $meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('met_decisions.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_decisions.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');

    }

    public function builder(): Builder
    {
        return Decision::query()
            ->where('met_decisions.meeting_id', $this->meetingId)
            ->orderBy('met_decisions.date', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Meeting"), "meeting.meeting_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Chairman"), "chairman")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Date"), "date")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("En Date"), "en_date")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('meeting_decision_update') || can('meeting_decision_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';
                if (can('meeting_decision_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('meeting_decision_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('meeting_decision_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.decisions.edit', ['meeting' => $this->meetingId, 'id' => $id]);
    }

    public function delete($id)
    {
        if (!can('meeting_decision_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DecisionAdminService();
        $service->delete(Decision::findOrFail($id));
        $this->successFlash("Decision Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('meeting_decision_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DecisionAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new DecisionsExport($records), 'decisions.xlsx');
    }
}