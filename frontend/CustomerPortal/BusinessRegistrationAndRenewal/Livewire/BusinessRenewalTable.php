<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\BusinessRegistration\Exports\BusinessRenewalsExport;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;

class BusinessRenewalTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = BusinessRenewal::class;

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
        return BusinessRenewal::query()
            ->with(['fiscalYear', 'registration'])
            ->select('fiscal_year_id', 'business_registration_id', 'date_to_be_maintained', 'application_status')
            ->where('deleted_at', null)
            ->where('created_by', Auth::guard('customer')->id())
            ->orderBy('created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('Reg No'), 'reg_no')
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__("Fiscal Year"), "fiscal_year_id")
                ->label(function ($row) {
                    $fiscal_year_id = $row->fiscal_year_id ? $row->fiscalYear->year : '';
                    return "
                    <div>{$fiscal_year_id}</div>
                ";
                })
                ->sortable()
                ->searchable()
                ->html(),
            Column::make(__('Business Details'))
                ->label(function ($row) {
                    return view('BusinessRegistration::livewire.business-renewal-table.col-detail')->with([
                        'row' => $row
                    ])->render();
                })
                ->html()
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('registration', function ($query) use ($term) {
                        $query->where('entity_name', 'like', "%{$term}%")
                            ->orWhere('renew_date', 'like', "%{$term}%")
                            ->orWhere('registration_date', 'like', "%{$term}%")
                            ->orWhere('registration_number', 'like', "%{$term}%");
                    });
                }),
            Column::make(__('Date To Be Maintained'), 'date_to_be_maintained')
                ->label(function ($row) {
                    return $row->date_to_be_maintained  ?? 'N/A';
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('Status'), 'application_status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->application_status->value
                    ]);
                })
                ->collapseOnTablet(),
        ];

       
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

               
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $edit;
                return $buttons;
            })->html();

            $columns[] = $actionsColumn;

        return $columns;
    }

    public function refresh() {}

    public function edit($id)
    {
       
        return redirect()->route('customer.business_renewals.edit', ['id' => $id]);
    }

    public function delete($id)
    {
       
        $service = new BusinessRenewalAdminService();
        $service->delete(BusinessRenewal::findOrFail($id));
        $this->successFlash("Business Renewal Deleted Successfully");
    }

    public function deleteSelected()
    {
        
        $service = new BusinessRenewalAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new BusinessRenewalsExport($records), 'business_renewals.xlsx');
    }

    public function show($id)
    {
        return redirect()->route('customer.business-registration.renewals.show', ['id' => $id]);
    }
}
