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
use Src\GrantManagement\Models\Group;
use Src\GrantManagement\Service\GroupAdminService;

class GroupTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Group::class;
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
            ->setAdditionalSelects(['id', 'province_id', "local_body_id", 'district_id'])
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
        return Group::query()
            ->with(['province', 'district', 'localBody'])

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
            Column::make(__('grantmanagement::grantmanagement.identification_card_no'), "unique_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.group_name'), "name")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.address'))
                ->label(function ($row) {
                    $province = $row->province ? $row->province->title : '';
                    $district = $row->district ? $row->district->title : '';
                    $localBody = $row->localBody ? $row->localBody->title : '';
                    $ward = $row->ward_no;
                    $village = $row->village;
                    $tole = $row->tole;

                    $address = trim("{$province}, {$district}, {$localBody}, Ward {$ward}, {$village}, {$tole}");

                    return $address;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.registration_date'), "registration_date")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.registered_office'), "registered_office")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.vat_pan'), "vat_pan")->sortable()->searchable()->collapseOnTablet(),
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

                if (can(permissions: 'gms_activity delete')) {
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

    public function show($id)
    {
        if (!can('gms_activity view')) {
            SessionFlash::WARNING_FLASH(message: __('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.groups.show', ['id' => $id]);
    }
    public function edit($id)
    {
        if (!can('gms_activity edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        $this->dispatch('edit-group', $id);
    }
    public function delete($id)
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GroupAdminService();
        $service->delete(Group::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.group_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new GroupAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'groups.xlsx');
    }
}
