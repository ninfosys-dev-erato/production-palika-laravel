<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Yojana\Exports\ActivitiesExport;
use Src\Yojana\Models\Activity;
use Src\Yojana\Service\ActivityAdminService;

class ActivityTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Activity::class;
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
        return Activity::query()
            ->with(['unit', 'projectActivityGroup'])
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
            Column::make(__('yojana::yojana.group_name'), "group_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->projectActivityGroup ? $row->projectActivityGroup->title : "N/A";
                }),
            Column::make(__('yojana::yojana.code'), "code")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.ref_code'), "ref_code")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.unit'), "unit_id")->sortable()->searchable()->collapseOnTablet()
                ->format(function ($value, $row, $column) {
                    return $row->unit ? $row->unit->title : "N/A";
                }),
            BooleanColumn::make(__('yojana::yojana.qty_for'), "qty_for")->sortable()->searchable()->collapseOnTablet(),
            BooleanColumn::make(__('yojana::yojana.will_be_in_use'), "will_be_in_use")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan_basic_settings edit') || can('plan_basic_settings delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('plan_basic_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_basic_settings delete')) {
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
        if (!can('plan_basic_settings edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-activity', activity: $id);
        // return redirect()->route('admin.activities.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ActivityAdminService();
        $service->delete(Activity::findOrFail($id));
        $this->successFlash(__('yojana::yojana.activity_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new ActivityAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ActivitiesExport($records), 'activities.xlsx');
    }
}
