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
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Service\EnterpriseAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class EnterpriseTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Enterprise::class;
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
            ->setAdditionalSelects(['id', 'enterprise_type_id', 'province_id', "local_body_id", 'district_id'])
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
        return Enterprise::query()
            ->with('province', 'district', 'localBody', 'enterprise_type')
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
            Column::make(__('grantmanagement::grantmanagement.private_enterprisefirm_identity_card_no'), "unique_id")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.name_of_private_enterprisefirm'), "name")->sortable()->searchable()->collapseOnTablet(),
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
            Column::make(__('grantmanagement::grantmanagement.enterprise_type'))
                ->label(function ($row) {
                    return $row->enterprise_type?->title ?? '-';
                })
                ->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.vat__pan_sheet'), "vat_pan")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('enterprises edit') || can('enterprises delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('enterprises edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('enterprises view')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')"><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('enterprises delete')) {
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
    public function show($id)
    {
        if (!can('enterprises view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.enterprises.show', ['id' => $id]);

    }
    public function edit($id)
    {
        if (!can('enterprises edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.enterprises.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('enterprises delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EnterpriseAdminService();
        $service->delete(Enterprise::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.enterprise_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('enterprises delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new EnterpriseAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'enterprises.xlsx');
    }
}
