<?php

namespace Src\Yojana\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use Src\Yojana\Exports\YojanaExport;
use Src\Yojana\Models\Organization;
use Src\Yojana\Service\OrganizationAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;

class OrganizationTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = Organization::class;
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
        return Organization::query()
            ->select('*')
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

            Column::make(__('yojana::yojana.basic_info'))->label(function ($row) {
                $committeeName = $row->name ?? "N/A";
                $address = $row->address ?? "N/A";
                $panNumber = $row->pan_number ?? "N/A";
                $phoneNumber = $row->phone_number ?? "N/A";
                $type = $row->type->label() ?? "N/A";

                return
                    '<strong>' . __('yojana::yojana.committee_name') . ':</strong> ' . $committeeName . '<br>' .
                    '<strong>' . __('yojana::yojana.address') . ':</strong> ' . $address . '<br>' .
                    '<strong>' . __('yojana::yojana.pan_number') . ':</strong> ' . $panNumber . '<br>' .
                    '<strong>' . __('yojana::yojana.phone_number') . ':</strong> ' . $phoneNumber . '<br>' .
                    '<strong>' . __('yojana::yojana.type') . ':</strong> ' . $type;
            })->html()->sortable()->searchable()->collapseOnTablet(),


            Column::make(__('yojana::yojana.bank_details'))->label(function ($row) {
                $bankName = $row->bank_name ?? "N/A";
                $branch = $row->branch ?? "N/A";
                $accountNumber = $row->account_number ?? "N/A";

                return
                    '<strong>' . __('yojana::yojana.bank_name') . ':</strong> ' . $bankName . '<br>' .
                    '<strong>' . __('yojana::yojana.branch') . ':</strong> ' . $branch . '<br>' .
                    '<strong>' . __('yojana::yojana.account_number') . ':</strong> ' . $accountNumber;
            })->html()->sortable()->searchable()->collapseOnTablet(),


            Column::make(__('yojana::yojana.representative_details'))->label(function ($row) {
                $representative = $row->representative ?? "N/A";
                $post = $row->post ?? "N/A";
                $representative_address = $row->representative_address ?? "N/A";
                $mobile_number = $row->mobile_number ?? "N/A";


                return
                    '<strong>' . __('yojana::yojana.name') . ':</strong> ' . $representative . '<br>' .
                    '<strong>' . __('yojana::yojana.post') . ':</strong> ' . $post . '<br>' .
                    '<strong>' . __('yojana::yojana.address') . ':</strong> ' . $representative_address . '<br>' .
                    '<strong>' . __('yojana::yojana.mobile_number') . ':</strong> ' . $mobile_number;
            })->html()->sortable()->searchable()->collapseOnTablet(),

            //            Column::make(__('yojana::yojana.type'), "type") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.name'), "name") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.address'), "address") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.pan_number'), "pan_number") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.phone_number'), "phone_number") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.bank_name'), "bank_name") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.branch'), "branch") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.account_number'), "account_number") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.representative'), "representative") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.post'), "post") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.representative_address'), "representative_address") ->sortable()->searchable()->collapseOnTablet(),
            //Column::make(__('yojana::yojana.mobile_number'), "mobile_number") ->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan_committee_settings edit') || can('plan_committee_settings delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan_committee_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_committee_settings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('plan_committee_settings edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.organizations.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan_committee_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new OrganizationAdminService();
        $service->delete(Organization::findOrFail($id));
        $this->successFlash(__('yojana::yojana.organization_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan_committee_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new OrganizationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new YojanaExport($records), 'organizations.xlsx');
    }
}
