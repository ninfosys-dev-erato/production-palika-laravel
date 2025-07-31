<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Yojana\Exports\ApplicationsExport;
use Src\Yojana\Models\Application;
use Src\Yojana\Service\ApplicationAdminService;

class ApplicationTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Application::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_applications.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_applications.id'])
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
        return Application::query()
            ->with('bankDetail')
            ->where('pln_applications.deleted_at', null)
            ->where('pln_applications.deleted_by', null)
            ->orderBy('pln_applications.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.applicant_name'), "applicant_name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.address'), "address")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.mobile_number'), "mobile_number")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.bank'), "bankDetail.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.account_number'), "account_number")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('yojana::yojana.is_employee'), "is_employee")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('applications edit') || can('applications delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('applications edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('applications delete')) {
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
        if (!can('applications edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.applications.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('applications delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ApplicationAdminService();
        $service->delete(Application::findOrFail($id));
        $this->successFlash(__('yojana::yojana.application_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('applications delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ApplicationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ApplicationsExport($records), 'applications.xlsx');
    }
}
