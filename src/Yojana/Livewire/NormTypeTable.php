<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\NormTypesExport;
use Src\Yojana\Models\NormType;
use Src\Yojana\Service\NormTypeAdminService;

class NormTypeTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = NormType::class;
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
        return NormType::query()
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
            Column::make(__('yojana::yojana.authority_name'), "authority_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.year'), "year")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('norm_types edit') || can('norm_types delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('norm_types edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('norm_types delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('norm_types edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-normType', normType: $id);
        // return redirect()->route('admin.norm_types.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('norm_types delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new NormTypeAdminService();
        $service->delete(NormType::findOrFail($id));
        $this->successFlash(__('yojana::yojana.norm_type_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('norm_types delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new NormTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new NormTypesExport($records), 'norm_types.xlsx');
    }
}
