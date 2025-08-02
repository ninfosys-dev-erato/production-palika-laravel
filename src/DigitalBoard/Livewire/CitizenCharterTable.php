<?php

namespace Src\DigitalBoard\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\DigitalBoard\Exports\CitizenChartersExport;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Service\CitizenCharterAdminService;

class CitizenCharterTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = CitizenCharter::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
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
        return CitizenCharter::query()
            ->with(['branch', 'wards'])
            ->select([
                'tbl_citizen_charters.id',
                'tbl_citizen_charters.service',
                'tbl_citizen_charters.amount',
                'tbl_citizen_charters.time',
                'tbl_citizen_charters.required_document',
                'tbl_citizen_charters.responsible_person',
                'tbl_citizen_charters.can_show_on_admin'
            ])
            ->where('tbl_citizen_charters.deleted_at', null)
            ->where('tbl_citizen_charters.deleted_by', null)
            ->orderBy('tbl_citizen_charters.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('digitalboard::digitalboard.details'))
                ->label(function ($row) {
                    return view('DigitalBoard::livewire.table-columns.citizen-charter-details', [
                        'service' => $row->service,
                        'amount' => $row->amount,
                        'time' => $row->time,
                        'wards' => $row->wards->isEmpty() ? 'N/A' : $row->wards->pluck('ward')->implode(', ')
                    ])->render();
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('digitalboard::digitalboard.branch'), "branch.title")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('digitalboard::digitalboard.required_document'), "required_document")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('digitalboard::digitalboard.responsible_person'), "responsible_person")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('digitalboard::digitalboard.can_show_on_palika'), 'can_show_on_admin')
                ->format(function ($value, $row) {
                    $canShowOnAdmin = $row->can_show_on_admin == 1;
                    return view('livewire-tables.includes.columns.status_switch', [
                        'rowId' => $row->id,
                        'isActive' => $canShowOnAdmin
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];
        if (can('digital_board edit') || can('digital_board delete')) {
            $actionsColumn = Column::make(__('digitalboard::digitalboard.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('digital_board edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('digital_board delete')) {
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
        if (!can('digital_board edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.digital_board.citizen_charters.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CitizenCharterAdminService();
        $service->delete(CitizenCharter::findOrFail($id));
        $this->successFlash(__("Citizen Charter Deleted Successfully"));
    }
    public function deleteSelected()
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CitizenCharterAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CitizenChartersExport($records), 'citizen_charters.xlsx');
    }

    public function toggleStatus($id)
    {
        $notice = CitizenCharter::findOrFail($id);
        $service = new CitizenCharterAdminService();
        $service->toggleCanShowOnAdmin($notice);
    }
}
