<?php

namespace Src\Meetings\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Meetings\Exports\AgendasExport;
use Src\Meetings\Models\Agenda;
use Src\Meetings\Service\AgendaAdminService;

class AgendaTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    public int $meetingId;
    protected $model = Agenda::class;

    public function mount($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('met_agendas.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['met_agendas.id'])
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh');
    }

    public function builder(): Builder
    {
        return Agenda::query()
            ->where('met_agendas.meeting_id', $this->meetingId)
            ->orderBy('proposal', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Meeting"), "meeting.meeting_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Proposal"), "proposal")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__("Description"), "description")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__("Is Final"), "is_final")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('meeting_agenda_update') || can('meeting_agenda_delete')) {
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('meeting_agenda_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('meeting_agenda_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('meeting_agenda_update')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.agendas.edit', ['meeting'=>$this->meetingId,'id' => $id]);
    }

    public function delete($id)
    {
        if (!can('meeting_agenda_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AgendaAdminService();
        $service->delete(Agenda::findOrFail($id));
        $this->successFlash("Agenda Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('meeting_agenda_delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new AgendaAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new AgendasExport($records), 'agendas.xlsx');
    }
}