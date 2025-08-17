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
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Service\FarmerAdminService;

class FarmerTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = Farmer::class;
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
            ->setAdditionalSelects(['id', 'first_name', 'middle_name', 'last_name', 'user_id', 'province_id', "local_body_id", 'district_id'])
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
        return Farmer::query()
            ->with(['user', 'province', 'district', 'localBody'])
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
            Column::make(__('grantmanagement::grantmanagement.full_name'))
                ->label(function ($row) {
                    // return $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name;\
                    return $row->user?->name;
                })
                ->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.address'))
                ->label(function ($row) {
                    $province = $row?->province ? $row->province->title : '';
                    $district = $row?->district ? $row->district->title : '';
                    $localBody = $row?->localBody ? $row->localBody->title : '';
                    $ward = $row?->ward_no;
                    $village = $row?->village;
                    $tole = $row?->tole;

                    $address = trim("{$province}, {$district}, {$localBody}, Ward {$ward}, {$village}, {$tole}");

                    return $address;
                })
                ->collapseOnTablet(),

            Column::make(__('grantmanagement::grantmanagement.farmer_card_no'), "farmer_id_card_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.citizenship_no'), "citizenship_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('grantmanagement::grantmanagement.contact_no'), "phone_no")->sortable()->searchable()->collapseOnTablet(),
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
        return redirect()->route('admin.farmers.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FarmerAdminService();
        $service->delete(Farmer::findOrFail($id));
        $this->successFlash(__('grantmanagement::grantmanagement.farmer_deleted_successfully'));
    }

    public function show($id)
    {
        if (!can('gms_activity view')) {
            SessionFlash::WARNING_FLASH(__('grantmanagement::grantmanagement.you_cannot_perform_this_action'));
            return false;
        }

        return redirect()->route('admin.farmers.show', ['id' => $id]);
    }

    public function deleteSelected()
    {
        if (!can('gms_activity delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new FarmerAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new GrantManagementExport($records), 'farmers.xlsx');
    }
}
