<?php

namespace Src\Employees\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Employees\Models\Designation;
use Src\Employees\Service\DesignationAdminService;

class DesignationTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Designation::class;
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
        return Designation::query()
            ->orderBy('title','desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('employees::employees.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('employees::employees.title_en'), "title_en")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('designation edit') || can('designation delete')) {
            $actionsColumn = Column::make(__('employees::employees.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('designation edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('designation delete')) {
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
        if (!can('designation edit')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.employee.designation.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('designation delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DesignationAdminService();
        $service->delete(Designation::findOrFail($id));
        $this->successFlash(__('employees::employees.designation_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('designation delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new DesignationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

}

