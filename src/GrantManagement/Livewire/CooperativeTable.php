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
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Service\CooperativeAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class CooperativeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Cooperative::class;
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
            ->setAdditionalSelects(['id', 'cooperative_type_id', 'province_id', "local_body_id", 'district_id'])
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
        return Cooperative::query()
            ->with([
                'province',
                'district',
                'localBody',
                'cooperative_type'
            ])
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
            Column::make(__('grantmanagement::grantmanagement.registration_number'), "registration_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.name_of_the_cooperative'), "name")->sortable()->searchable()->collapseOnTablet(),
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
            Column::make(__('grantmanagement::grantmanagement.types_of_cooperatives'))
                ->label(function ($row) {
                    return $row->cooperative_type?->title ?? '-';
                }),
            Column::make(__('grantmanagement::grantmanagement.sheetvat'), "vat_pan")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('cooperatives edit') || can('cooperatives delete')) {
            $actionsColumn = Column::make(__('grantmanagement::grantmanagement.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('cooperatives edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('grant_releases view')) {
                    $view = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')"><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('cooperatives delete')) {
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
        if (!can('cooperatives edit')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.cooperative.edit', ['id' => $id]);
    }

    public function show($id)
    {
        if (!can('grant_releases view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.cooperative.show', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('cooperatives delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CooperativeAdminService();
        $service->delete(Cooperative::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.cooperative_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('cooperatives delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CooperativeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'cooperatives.xlsx');
    }
}
