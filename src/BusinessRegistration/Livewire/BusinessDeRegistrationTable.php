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
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessDeRegistrationService;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;

class BusinessDeRegistrationTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = BusinessRegistration::class;

    public $type;

    public function mount($type)
    {
        $this->type = $type;
    }

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('brs_business_deregistration_data.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['brs_business_deregistration_data.id'])
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
        return BusinessDeRegistration::query()
            ->with([
                'businessRegistration',
                'businessRegistration.businessProvince',
                'businessRegistration.businessDistrict',
                'businessRegistration.businessLocalBody',
                'businessRegistration.applicants',
                'businessRegistration.applicants.applicantProvince',
                'businessRegistration.applicants.applicantDistrict',
                'businessRegistration.applicants.applicantLocalBody',
            ])
            ->select('*')
            ->whereNull(['brs_business_deregistration_data.deleted_at'])
            ->orderBy('brs_business_deregistration_data.created_at', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [

            Column::make(__('businessregistration::businessregistration.registration_date'), "application_date")
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.business_name'), "businessRegistration.entity_name")
                ->sortable()
                ->searchable()
                ->html(),
            Column::make(__('businessregistration::businessregistration.certificate_number'), "registration_number")
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.applicant_name'))
                ->label(function ($row) {
                    $firstApplicant = $row->businessRegistration?->applicants->first();
                    return $firstApplicant ? $firstApplicant->applicant_name : '';
                })
                ->sortable()
                ->searchable()
                ->html(),


            Column::make(__('businessregistration::businessregistration.applicant_address'))
                ->label(function ($row) {

                    $firstApplicant = $row->businessRegistration?->applicants->first();
                    if ($firstApplicant) {
                        $applicant_name = $firstApplicant->applicant_name;
                        $applicant_number = $firstApplicant->phone;
                        $province = $firstApplicant->applicantProvince?->title;
                        $district = $firstApplicant->applicantDistrict?->title;
                        $localBody = $firstApplicant->applicantLocalBody?->title;
                        $ward = $firstApplicant->applicant_ward;

                        $parts = collect([$applicant_name, $applicant_number, $province, $district, $localBody, $ward])
                            ->filter()
                            ->implode(', ');

                        return $parts;
                    }
                    return '';
                })
                ->sortable()
                ->searchable()
                ->html(),

            Column::make(__('businessregistration::businessregistration.business_address'))->label(
                function ($row) {
                    $province = $row->businessRegistration?->businessProvince?->title;
                    $district = $row->businessRegistration?->businessDistrict?->title;
                    $localBody = $row->businessRegistration?->businessLocalBody?->title;
                    $ward = $row->businessRegistration?->business_ward;
                    $tole = $row->businessRegistration?->business_tole;
                    $street = $row->businessRegistration?->business_street;

                    return collect([$province, $district, $localBody, $ward, $tole, $street])
                        ->filter()
                        ->implode(', ');
                }
            )->html()->searchable(),

            Column::make(__('businessregistration::businessregistration.status'), 'application_status')
                ->format(function ($value, $row) {
                    return $row->application_status->label();
                })
                ->collapseOnTablet(),


        ];
        if (can('business_registration edit') || can('business_registration delete')) {
            $actionsColumn = Column::make(__('businessregistration::businessregistration.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                $buttons .= $view;


                if (can('business_registration edit') && $row->application_status !== ApplicationStatusEnum::ACCEPTED) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('business_registration delete') && $row->application_status !== ApplicationStatusEnum::ACCEPTED) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                }


                if ($row->application_status === ApplicationStatusEnum::ACCEPTED) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm"  wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
                }




                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }

    public function refresh() {}

    public function view($id)
    {
        return redirect()->route('admin.business-deregistration.show', ['id' => $id]);
    }

    public function edit($id)
    {
        if (!can('business_registration edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.business-deregistration.edit', ['id' => $id, 'type' => $this->type]);
    }

    public function delete($id)
    {
        if (!can('business_registration delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BusinessDeRegistrationService();
        $business = BusinessDeRegistration::findOrFail($id);
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

    public function preview($id)
    {
        return redirect()->route('admin.business-deregistration.preview', ['id' => $id]);
    }
}
