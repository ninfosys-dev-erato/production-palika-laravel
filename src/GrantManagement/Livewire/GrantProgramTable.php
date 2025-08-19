<?php

namespace Src\GrantManagement\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\GrantManagement\Exports\GrantManagementExport;
use Src\GrantManagement\Models\GrantProgram;
use Src\GrantManagement\Service\GrantProgramAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class GrantProgramTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = GrantProgram::class;
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
            ->setAdditionalSelects(['id', 'for_grant', 'grant_provided_type', 'fiscal_year_id', 'type_of_grant_id', 'granting_organization_id', 'branch_id'])
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
        return GrantProgram::query()
            ->select('*')
            ->with(['fiscalYear', 'grantType', 'grantingOrganization', 'branch'])
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
            Column::make(__('grantmanagement::grantmanagement.fiscal_year'))
                ->label(function ($row) {
                    return $row->fiscalYear->year;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.grant_giving_organization'))
                ->label(function ($row) {
                    return $row->grantingOrganization?->office_name_en;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.name_of_the_grant_program'), "program_name")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.type_of_grant'))
                ->label(function ($row) {
                    return $row->grantType?->title;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.grant_delivered_type'))
                ->label(function ($row) {
                    return $row->grant_provided_type;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.branch'))
                ->label(function ($row) {
                    return $row->branch?->title_en;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.for_grants'))
                ->label(function ($row) {
                    if (is_array($row->for_grant)) {
                        $values = [];
                        foreach ($row->for_grant as $item) {
                            $values[] = $item;
                        }
                        return implode(', ', $values);
                    }
                    return '-';
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.decision_type'))
                ->label(function ($row) {
                    return $row->decision_type?->label() ?? '-';
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.decision_date'))
                ->label(function ($row) {
                    return $row->decision_date ?? '-';
                })
                ->collapseOnTablet(),

        ];


        if (can('gms_activity edit') || can('gms_activity delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('gms_activity edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('gms_activity delete')) {
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
        if (!can('gms_activity edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.grant_programs.edit', ['id' => $id]);
    }


    public function show($id)
    {
        if (!can('gms_activity view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.grant_programs.show', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrantProgramAdminService();
        $service->delete(GrantProgram::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.grant_program_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GrantProgramAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'grant-programs.xlsx');
    }
}
