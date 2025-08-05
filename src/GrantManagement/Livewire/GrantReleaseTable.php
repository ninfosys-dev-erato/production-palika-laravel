<?php

namespace Src\GrantManagement\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\GrantManagement\Exports\GrantManagementExport;
use Src\GrantManagement\Models\GrantRelease;
use Src\GrantManagement\Service\GrantReleaseAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class GrantReleaseTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = GrantRelease::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => 'table table-bordered table-hover dataTable dtr-inline',
            ])
            ->setAdditionalSelects(['id', 'grantee_id', 'grantee_type', 'grant_program'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllDisabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        return GrantRelease::query()
            ->with('grantProgram', 'grantProgram.fiscalYear')
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->orderByDesc('created_at');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            // Column::make(__('grantmanagement::grantmanagement.programmesactivities'), 'grantee')->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.programmesactivities'))
                ->label(function ($row) {
                    return optional($row->grantProgram)->program_name
                        . ' (' . optional($row->grantProgram->fiscalYear)->year . ')';
                }),
            Column::make(__('grantmanagement::grantmanagement.grantee_name'))
                ->label(function ($row) {
                    try {
                        if (!empty($row->grantee_type) && class_exists($row->grantee_type)) {
                            $grantee = app($row->grantee_type)::find($row->grantee_id);

                            if ($grantee->getTable() === 'gms_cooperatives' || $grantee->getTable() === "gms_groups" || $grantee->getTable() === 'gms_enterprises') {
                                return $grantee->name;
                            } else if ($grantee->getTable() === 'gms_farmers') {
                                return $grantee->name = collect([$grantee->first_name, $grantee->middle_name, $grantee->last_name])
                                    ->filter()
                                    ->join(' ');
                            }
                        }
                    } catch (\Throwable $e) {
                        return 'Error: ' . $e->getMessage();
                    }
                }),

            Column::make(__('grantmanagement::grantmanagement.grantee_investment'), 'investment')->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.newcontinuous'), 'is_new_or_ongoing')->sortable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.planning_site'), 'last_year_investment')->sortable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.contact_number'), 'location')->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.grant_expenses'), 'grant_expenses')->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.private_expenses'), 'private_expenses')->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('gms_activity edit') || can('gms_activity delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('gms_activity edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }
                if (can('gms_activity view')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')"><i 
                    class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
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

        return redirect()->route('admin.grant_release.edit', ['id' => $id]);
    }

    public function show($id)
    {
        if (!can('gms_activity view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.grant_release.show', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        $service = new GrantReleaseAdminService();
        $service->delete(GrantRelease::findOrFail($id));

        $this->successFlash(__('grantmanagement::grantmanagement.grant_release_deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        $service = new GrantReleaseAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();

        return Excel::download(new GrantManagementExport($records), 'grant-releases.xlsx');
    }
}
