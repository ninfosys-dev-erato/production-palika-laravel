<?php

namespace Src\BusinessRegistration\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
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
            ->with(['fiscalYear', 'registration', 'registration.province', 'registration.district', 'registration.localBody', 'registration.registrationType.registrationCategory'])
            ->select('*')
            ->where('deleted_at', null)
            ->orderBy('created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('businessregistration::businessregistration.reg_no'), 'reg_no')
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.fiscal_year'), "fiscal_year_id")
                ->label(function ($row) {
                    $fiscal_year_id = $row->fiscal_year_id ? $row->fiscalYear->year : '';
                    return "
                    <div>{$fiscal_year_id}</div>
                ";
                })
                ->sortable()
                ->searchable()
                ->html(),
            Column::make(__('businessregistration::businessregistration.registration_details'))
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
            Column::make(__('businessregistration::businessregistration.business_detail'))
                ->label(function ($row) {
                    $entity_name = $row->registration?->entity_name;
                    $registration_type = $row->registration?->registrationType?->title;
                    $registration_category = $row->registration?->registrationType?->registrationCategory?->title_ne;
                    return "
                     <div><strong>" . (__('businessregistration::businessregistration.entity_name')) . ":" . "</strong> {$entity_name}</div>
                         <div><strong>" . (__('businessregistration::businessregistration.category')) . ":" . "</strong> {$registration_category}</div>
                        <div><strong>" . (__('businessregistration::businessregistration.type')) . ":" . "</strong> {$registration_type}</div>                       
                    ";
                })
                ->sortable()
                ->searchable()
                ->html(),
            Column::make(__('businessregistration::businessregistration.applicant_detail'))
                ->label(function ($row) {
                    $applicant_name = $row->registration?->applicant_name;
                    $applicant_number = $row->registration?->applicant_number;
                    return "
                        <div><strong>" . (__('businessregistration::businessregistration.applicant_name')) . ":" . "</strong> {$applicant_name}</div>
                          <div><strong>" . (__('businessregistration::businessregistration.applicant_number')) . ":" . "</strong> {$applicant_number}</div>
                    ";
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.address'))->label(
                fn($row, Column $column) => view('BusinessRegistration::livewire.business-renewal-table.address-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('businessregistration::businessregistration.date_to_be_maintained'), 'date_to_be_maintained')
                ->label(function ($row) {
                    return $row->date_to_be_maintained ?? 'N/A';
                })
                ->sortable()
                ->searchable()
                ->html(),
        ];

        if (can('business_renewals access')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('business_renewals access')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="show(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $edit;
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
        if (!can('business_renewals edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.business_renewals.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('business_renewals delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BusinessRenewalAdminService();
        $service->delete(BusinessRenewal::findOrFail($id));
        $this->successFlash("Business Renewal Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('business_renewals delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
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
        if (!can('business_renewals access')) {
            $this->errorFlash('Yu cannot perform this action');
            return false;
        }

        return redirect()->route('admin.business-registration.renewals.show', ['id' => $id]);
    }
}
