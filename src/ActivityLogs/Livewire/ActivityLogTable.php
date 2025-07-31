<?php

namespace Src\ActivityLogs\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\ActivityLogs\Exports\ActivityLogsExport;
use Src\ActivityLogs\Models\ActivityLog;
use Src\ActivityLogs\Service\ActivityLogAdminService;

class ActivityLogTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = ActivityLog::class;

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
        return ActivityLog::query()
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Description"), "description")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make(__("Event"), "event")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    return ucwords(str_replace('-', ' ', $value));
                }),

            Column::make(__("Subject"), "subject_type")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    return class_basename($value);
                }),

            Column::make(__("Actor"), "causer_type")
                ->sortable()
                ->searchable()
                ->collapseOnTablet()
                ->format(function ($value) {
                    return class_basename($value);
                }),
        ];

        if (can('activity_logs edit') || can('activity_logs delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';
                if (can('activity_logs view')) {
                    $delete = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $delete;
                }

                if (can('activity_logs edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('activity_logs delete')) {
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
        if (!can('activity_logs edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.activity_logs.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('activity_logs delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ActivityLogAdminService();
        $service->delete(ActivityLog::findOrFail($id));
        $this->successFlash("Activity Log Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('activity_logs delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ActivityLogAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ActivityLogsExport($records), 'activity_logs.xlsx');
    }
    public function view(int $id)
    {
        return redirect()->route('admin.activity_logs.show', $id);
    }
}
