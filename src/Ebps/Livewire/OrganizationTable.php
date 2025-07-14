<?php

namespace Src\Ebps\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Ebps\Exports\OrganizationsExport;
use Src\Ebps\Models\Organization;
use Src\Ebps\Service\OrganizationAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class OrganizationTable extends DataTableComponent
{
    use SessionFlash,IsSearchable;
    protected $model = Organization::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100,500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return Organization::query()
            ->with(['province', 'district', 'localBody'])
            ->select('org_name_ne', 'org_name_en', 'org_email', 'org_contact','province_id', 'district_id', 'local_body_id', 'ward', 'org_registration_no', 'org_registration_date', 'org_pan_no', 'org_pan_registration_date')
            ->where('deleted_at',null)
            ->where('deleted_by',null)
            ->orderBy('created_at','DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ebps::ebps.organization_details'))->label(
                fn ($row, Column $column) => view('Ebps::livewire.organization-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('ebps::ebps.contact_details'))->label(
                fn ($row, Column $column) => view('Ebps::livewire.organization-table.col-contact')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('ebps::ebps.registration_details'))->label(
                fn ($row, Column $column) => view('Ebps::livewire.organization-table.col-reg')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('ebps::ebps.pan_details'))->label(
                fn ($row, Column $column) => view('Ebps::livewire.organization-table.col-pan')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
        ];
        if (can('ebps_organizations edit') || can('ebps_organizations delete')) {
            $actionsColumn = Column::make(__('ebps::ebps.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('ebps_organizations access')) {
                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('ebps_organizations delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('ebps_organizations edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.ebps.organizations.edit',['id'=>$id]);
    }

    public function view($id)
    {
        if (!can('ebps_organizations access')) {
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ebps.organizations.show',  $id);
    }

    public function delete($id)
    {
        if(!can('ebps_organizations delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                return false;
        }
        $service = new OrganizationAdminService();
        $service->delete(Organization::findOrFail($id));
        $this->successFlash(__('ebps::ebps.organization_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('ebps_organizations delete')){
            $this->warningFlash(__('ebps::ebps.you_cannot_perform_this_action'));
                    return false;
        }
        $service = new OrganizationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new OrganizationsExport($records), 'organizations.xlsx');
    }
}
