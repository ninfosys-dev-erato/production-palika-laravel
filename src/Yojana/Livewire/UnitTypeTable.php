<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Yojana\Exports\UnitTypesExport;
use Src\Yojana\Models\UnitType;
use Src\Yojana\Service\UnitTypeAdminService;

class UnitTypeTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = UnitType::class;
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
            ->setAdditionalSelects(['id'])
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
        return UnitType::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.title_en'), "title_en")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.display_order'), "display_order")->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.will_be_in_use'), "will_be_in_use") ->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('yojana::yojana.will_be_in_use'), "will_be_in_use")->sortable()->searchable()->collapseOnTablet(),

        ];
        if (can('unit_types edit') || can('unit_types delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('unit_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('unit_types delete')) {
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
        if (!can('unit_types edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        //        return redirect()->route('admin.unit_types.edit',['id'=>$id]);
        $this->dispatch('edit-unit-type', $id);
    }
    public function delete($id)
    {
        if (!can('unit_types delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new UnitTypeAdminService();
        $service->delete(UnitType::findOrFail($id));
        $this->successFlash(__('yojana::yojana.unit_type_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('unit_types delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new UnitTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new UnitTypesExport($records), 'unit_types.xlsx');
    }
}
