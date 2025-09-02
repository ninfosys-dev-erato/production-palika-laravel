<?php

namespace Src\BusinessRegistration\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\Customers\Models\Customer;

class BusinessRegistrationTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = BusinessRegistration::class;

    public $type;
    public $isCustomer = false;
    public $customerData;

    public function mount($type)
    {
        $this->type = $type;
        if (Auth::guard('customer')->user()) {
            $this->isCustomer = true;
        }
    }

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('brs_business_registration_data.id')
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
            ->with([
                'registrationType.registrationCategory',
                'businessProvince',
                'businessDistrict',
                'businessLocalBody',
                'applicants',
                'applicants.applicantProvince',
                'applicants.applicantDistrict',
                'applicants.applicantLocalBody',
            ])

            ->select('*')
            ->when($this->isCustomer, function ($query) {
                $query->whereHas('applicants', function ($subQuery) {
                    $user = Auth::guard('customer')->user();
                    $subQuery->where('phone', $user->mobile_no)
                        ->orWhere('email', $user->email);
                });
            })
            ->when($this->type == BusinessRegistrationType::ARCHIVING, function ($query) {
                $query->where('registration_type', BusinessRegistrationType::ARCHIVING);
            })
            ->whereNull(['brs_business_registration_data.deleted_at'])
            ->orderBy('brs_business_registration_data.created_at', 'desc');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('businessregistration::businessregistration.type'))
                ->options(
                    ['' => __('businessregistration::businessregistration.all')] + \Src\BusinessRegistration\Models\RegistrationType::pluck('title', 'id')->toArray()
                )
                ->filter(function (Builder $query, $value) {
                    if (!empty($value)) {
                        $query->where('brs_business_registration.registration_type_id', $value)->whereNull('deleted_at');
                    }
                }),
        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('businessregistration::businessregistration.registration_details'))->label(
                fn($row, Column $column) => view('BusinessRegistration::livewire.business-registration-table.col-detail')->with([
                    'row' => $row
                ])->render()
            )->html()
                ->searchable(),


            Column::make(__('businessregistration::businessregistration.registration_type'), "registration_type_id")
                ->label(function ($row) {
                    $registration_type_id = $row->registration_type_id ? $row->registrationType?->title : '';
                    $registration_type_enum = RegistrationCategoryEnum::tryFrom($row->registration_category)?->label()
                        ?? RegistrationCategoryEnum::BUSINESS->label();
                    return "
                        <div><strong>" . (__('businessregistration::businessregistration.type')) . ":" . "</strong> {$registration_type_id}</div>
                         <div><strong>" . (__('businessregistration::businessregistration.registration_category')) . ":" . "</strong> {$registration_type_enum}</div>


                      
                    ";
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.personal_detail'))
                ->label(function ($row) {
                    $firstApplicant = $row->applicants->first();

                    if ($firstApplicant) {
                        $applicant_name = $firstApplicant->applicant_name;
                        $applicant_number = $firstApplicant->phone;
                        $province = $firstApplicant->applicantProvince?->title;
                        $district = $firstApplicant->applicantDistrict?->title;
                        $localBody = $firstApplicant->applicantLocalBody?->title;
                        $ward = $firstApplicant->applicant_ward;
                        $applicant_address = collect([$province, $district, $localBody, $ward])->filter()->implode(', ');
                        return "
                            <div><strong>" . (__('businessregistration::businessregistration.name')) . ":</strong> {$applicant_name}</div>
                            <div><strong>" . (__('businessregistration::businessregistration.number')) . ":</strong> {$applicant_number}</div>
                            <div><strong>" . (__('businessregistration::businessregistration.address')) . ":</strong> {$applicant_address}</div>
                        ";
                    }
                    return '';
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.business_address'))->label(
                fn($row, Column $column) => view('BusinessRegistration::livewire.business-registration-table.address-detail')->with([
                    'row' => $row
                ])->render()
            )->html()->searchable(),
            Column::make(__('businessregistration::businessregistration.status'), 'application_status')
                ->format(function ($value, $row) {
                    return view('livewire-tables.includes.columns.status_text', [
                        'status' => $row->application_status
                    ]);
                })
                ->collapseOnTablet(),


        ];
        if (can('business_registration edit') || can('business_registration delete')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('business_registration access')) {
                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                }

                if (can('business_registration edit') && $row->application_status !== ApplicationStatusEnum::ACCEPTED->value) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }


                if (can('business_registration delete') && $row->application_status !== ApplicationStatusEnum::ACCEPTED->value) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                }


                if ($row->application_status === ApplicationStatusEnum::ACCEPTED->value) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm"  wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
                }


                if ($row->application_status === ApplicationStatusEnum::ACCEPTED->value) {
                    $renewButton = '<button type="button" class="btn btn-secondary btn-sm" wire:click="renew(' . $row->id . ')"><i class="bx bx-refresh"></i></button>';
                    $buttons .= $renewButton;
                }
                // $ownershipTransfer = '<button type="button" class="btn btn-secondary btn-sm" wire:click="ownerShipTransfer(' . $row->id . ')"><i class="bx bx-transfer"></i></button>';
                // $buttons .= $ownershipTransfer;
                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        }
        if ($this->isCustomer) {
            $columns[] = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group">';

                $buttons .= '<button class="btn btn-success btn-sm" wire:click="customerView(' . $row->id . ')"><i class="bx bx-show"></i></button>&nbsp;';

                if ($row->application_status !== ApplicationStatusEnum::ACCEPTED->value) {
                    $buttons .= '<button class="btn btn-primary btn-sm" wire:click="customerEdit(' . $row->id . ')"><i class="bx bx-edit"></i></button>&nbsp;';
                }


                if ($row->application_status !== ApplicationStatusEnum::ACCEPTED->value) {
                    $buttons .= '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="customerDelete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                }
                if ($row->application_status === ApplicationStatusEnum::ACCEPTED->value) {
                    $buttons .= '<button type="button" class="btn btn-primary btn-sm" wire:click="customerPreview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                }

                // Show renew button if accepted and not deregistration
                // if ($row->application_status === ApplicationStatusEnum::ACCEPTED->value) {
                //     $buttons .= '<button type="button" class="btn btn-secondary btn-sm" wire:click="renew(' . $row->id . ')"><i class="bx bx-refresh"></i></button>';
                // }

                return $buttons . '</div>';
            })->html();
        }


        return $columns;
    }

    public function refresh() {}

    public function view($id)
    {
        return redirect()->route('admin.business-registration.business-registration.show', [
            'id' => $id,
            'type' => $this->type
        ]);
    }

    public function edit($id)
    {
        if (!can('business_registration edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.business-registration.business-registration.edit', ['id' => $id, 'type' => $this->type]);
    }

    public function delete($id)
    {
        if (!can('business_registration delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BusinessRegistrationAdminService();
        $business = BusinessRegistration::findOrFail($id);
        $service->delete($business);
        $this->successFlash("Registration Type Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('business_registration delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BusinessRegistrationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function renew($id)
    {
        $fiscalYearId = getCurrentFiscalYear()->id;

        // ✅ Check if a renewal already exists for this business in the current fiscal year
        $exists = BusinessRenewal::where('business_registration_id', $id)
            ->where('fiscal_year_id', $fiscalYearId)
            ->exists();

        if ($exists) {
            $this->errorFlash(__('businessregistration::businessregistration.renewal_already_exists_for_fiscal_year'));
            return redirect()->back();
        }

        $registrationNumber = BusinessRegistration::where('id', $id)->value('registration_number');

        $renewal = BusinessRenewal::create([
            'business_registration_id' => $id,
            'fiscal_year_id' => $fiscalYearId,
            'registration_no' => $registrationNumber,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
            'application_status' => ApplicationStatusEnum::PENDING->value,
        ]);

        $this->successFlash(__('businessregistration::businessregistration.application_for_renewal_successful'));
        return redirect()->route('admin.business-registration.renewals.show', ['id' => $renewal->id]);
    }


    public function preview($id)
    {
        return redirect()->route('admin.business-registration.business-registration.preview', [
            'id' => $id,
            'type' => $this->type
        ]);
    }

    // Customer Portal Functions for Action buttons
    public function customerView($id)
    {
        return redirect()->route('customer.business-registration.business-registration.show', ['id' => $id]);
    }

    public function customerEdit($id)
    {
        return redirect()->route('customer.business-registration.business-registration.edit', ['id' => $id]);
    }

    public function customerDelete($id)
    {
        $service = new BusinessRegistrationAdminService();
        $business = BusinessRegistration::findOrFail($id);
        $service->delete($business, false);
        $this->successFlash("Registration Deleted Successfully");
    }

    public function customerPreview($id)
    {
        return redirect()->route('customer.business-registration.business-registration.preview', ['id' => $id]);
    }

    public function ownerShipTransfer($id)
    {
        return redirect()->route('admin.business-registration.business-registration.ownership-transfer', ['id' => $id]);
    }
}
