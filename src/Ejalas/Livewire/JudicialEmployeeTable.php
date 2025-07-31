<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\JudicialEmployeesExport;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Service\JudicialEmployeeAdminService;

class JudicialEmployeeTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = JudicialEmployee::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_judicial_employees.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_judicial_employees.id'])
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
        return JudicialEmployee::query()
            ->select('*')
            ->with(['localLevel', 'level', 'designation'])
            ->where('jms_judicial_employees.deleted_at', null)
            ->where('jms_judicial_employees.deleted_by', null)
            ->orderBy('jms_judicial_employees.created_at', 'DESC'); // Select some things

    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.ejalashemployeename'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.local_level'), "localLevel.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ward'), "ward_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.level'), "level.title_en")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.designation'), "designation.title_en")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.ejalashemployeerestorationdate'), "join_date")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.contact_info'))->label(function ($row) {
            //     return "<strong>Phone No:</strong> {$row->phone_no} <br>
            //             <strong>Email:</strong> {$row->email}";
            // })->html()
            //     ->sortable()
            //     ->searchable()
            //     ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.phone_no'), 'phone_no')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.email'), 'email')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),


        ];
        if (can('judicial_employees edit') || can('judicial_employees delete')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('judicial_employees edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('judicial_employees delete')) {
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
        if (!can('judicial_employees edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }

        return $this->dispatch('edit-judicial-employee', $id);
        // return redirect()->route('admin.ejalas.judicial_employees.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('judicial_employees delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialEmployeeAdminService();
        $service->delete(JudicialEmployee::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.judicial_employee_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('judicial_employees delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new JudicialEmployeeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new JudicialEmployeesExport($records), 'judicial_employees.xlsx');
    }
}
