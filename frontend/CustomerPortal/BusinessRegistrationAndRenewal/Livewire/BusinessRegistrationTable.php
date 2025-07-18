<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessRegistrationTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = BusinessRegistration::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('brs_business_registration.id')
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
        return BusinessRegistration::query()
            ->with(['registrationType.registrationCategory', 'province', 'district', 'localBody'])
            ->select('province_id', 'district_id', 'tole', 'ward_no', 'local_body_id', 'entity_name', 'registration_date', 'application_date', 'certificate_number', 'registration_type_id', 'registration_number')
            ->where('brs_business_registration.deleted_at', null)
            ->where('brs_business_registration.created_by', Auth::guard('customer')->id())
            ->whereNull(['brs_business_registration.deleted_at'])
            ->orderBy('brs_business_registration.created_at', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__("Business Details"))->label(
                fn($row, Column $column) => view('BusinessRegistration::livewire.business-registration-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()
                ->searchable(),
            Column::make(__("Registration Type"), "registration_type_id")
                ->label(function ($row) {
                    $registration_type = $row->registrationType;
                    $registration_type_title = $registration_type?->title ?? '';
                    $registration_category_title = $registration_type?->registrationCategory?->title_ne ?? '';
                    
                    return "
                        <div><strong>Category:</strong> {$registration_category_title}</div>
                        <div><strong>Type:</strong> {$registration_type_title}</div>
                    ";
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__("Address"))->label(
                fn($row, Column $column) => view('BusinessRegistration::livewire.business-registration-table.address-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('Status'), 'application_status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->application_status
                    ]);
                })
                ->collapseOnTablet(),


        ];
        
            $actionsColumn = Column::make(__('Actions'))->label(function ($row, Column $column) {
                $buttons = '';

                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                    $renewButton = '<button type="button" class="btn btn-secondary btn-sm" wire:click="renew(' . $row->id . ')"><i class="bx bx-refresh"></i></button>';
                    $buttons .= $renewButton;
                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        return $columns;
    }

    public function refresh() {}

    public  function view($id)
    {
        return redirect()->route('customer.business-registration.business-registration.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return redirect()->route('customer.business-registration.business-registration.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $service = new BusinessRegistrationAdminService();
        $service->delete(BusinessRegistration::findOrFail($id));
        $this->successFlash("Registration Type Deleted Successfully");
    }

    public function deleteSelected()
    {
        $service = new BusinessRegistrationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function renew($id)
    {

        $registrationNumber = BusinessRegistration::where('id', $id)->value('registration_number');
        BusinessRenewal::create([
            'business_registration_id' => $id,
            'fiscal_year_id' => getCurrentFiscalYear()->id,
            'registration_no' => $registrationNumber,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::guard('customer')->id(),
            'application_status' => ApplicationStatusEnum::PENDING->value,
        ]);

        $this->successFlash(__('Application for renewal successful'));
        return redirect()->route('customer.business-registration.business-registration.index');
    }
}
