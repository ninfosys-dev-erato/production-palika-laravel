<?php

namespace Src\Grievance\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Grievance\Models\GrievanceType;
use Src\Grievance\Service\GrievanceTypeAdminService;

class GrievanceTypeTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = GrievanceType::class;
    public array $bulkActions = [

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
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        return GrievanceType::query()
            ->with('roles')
            ->latest();
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('grievance::grievance.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grievance::grievance.assigned_to'))->label(
                fn($row, Column $column) => view('Grievance::livewire.grievance-detail-table.col-notifee')->with([
                    'roles' => $row->roles,
                ])
            )->html(),
            BooleanColumn::make(__('grievance::grievance.is_for_ward'), "is_ward")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('grievance_setting edit') || can('grievance_setting delete')) {
            $actionsColumn = Column::make(__('grievance::grievance.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('grievance_setting edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('grievance_setting delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('grievance_setting access')) {
                    $manage = '&nbsp;<button type="button" class="btn btn-success btn-sm ml-2" wire:click="manage(' . $row->id . ')"><i class="bx bx-cog"></i></button>';
                    $buttons .= $manage;
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
        if (!can('grievance_setting edit')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.grievance.grievanceType.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('grievance_setting delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrievanceTypeAdminService();
        $service->delete(GrievanceType::findOrFail($id));
        $this->successFlash(__('grievance::grievance.grievance_setting deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('grievance_setting delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrievanceTypeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function manage(int $grievanceTypeId)
    {
        return redirect()->route('admin.grievance.grievanceType.manage', ['id' => $grievanceTypeId]);
    }
}
