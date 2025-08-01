<?php

namespace Src\FileTracking\Livewire;


use App\Facades\GlobalFacade;
use App\Models\User;
use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Src\Employees\Models\Branch;
use Src\FileTracking\Exports\FileRecordsExport;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Service\FileRecordAdminService;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\FileTracking\Enums\SenderMediumEnum;
use Src\Settings\Models\FiscalYear;

class ChalaniTable extends DataTableComponent
{
    use SessionFlash, IsSearchable, HelperDate;
    protected $model = FileRecord::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('tbl_file_records.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['tbl_file_records.id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setRefreshKeepAlive()
            ->setSearchLive()
            ->setBulkActionConfirms([
                'delete',
            ]);
        $this->setSearchLive();
        $this->setSearchPlaceholder(__('Enter Chalani No / Letter Receivers` Name'));
    }
    public function mount()
    {
        $currentFiscalYear =  key(getSettingWithKey('fiscal-year'));
        $this->setFilter('fiscal_year', $currentFiscalYear);
    }
    public function builder(): Builder
    {
        $query = FileRecord::query()
            ->with('fiscalYear') // Only eager load what's needed
            ->select([
                'tbl_file_records.id',
                'applicant_name',
                'applicant_mobile_no',
                'recipient_name',
                'recipient_department',
                'recipient_position',
                'signee_name',
                'signee_department',
                'signee_position',
                'sender_medium',
                'reg_no',
                'title',
                'fiscal_year',
                'registration_date',
            ])
            ->whereNull('tbl_file_records.deleted_at')
            ->whereNull('tbl_file_records.deleted_by')
            ->where('tbl_file_records.is_chalani', true)
            ->whereNotNull('tbl_file_records.reg_no')
            ->orderByDesc('tbl_file_records.registration_date')
            ->orderByDesc('tbl_file_records.reg_no');

        $user = auth()->user()->fresh();
        $departmentId = GlobalFacade::department();
        $ward = GlobalFacade::ward();

        if (!isSuperAdmin()) {
            if (!$departmentId && !$ward) {
                return $query->where('tbl_file_records.id', -1); // No match for restricted user
            }

            if ($departmentId) {
                $query->where('tbl_file_records.branch_id', $departmentId);
            }

            if ($ward) {
                $query->where('tbl_file_records.ward', $ward);
            }
        }

        return $query;
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('filetracking::filetracking.sender_medium'))
                ->options([
                    '' => 'All',
                    'email' => 'Email',
                    'post_office' => 'Post Office',
                    'hardcopy' => 'Hardcopy',
                    'through_personal' => 'Through Personal',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('sender_medium', $value);
                    }
                }),
            SelectFilter::make(__('filetracking::filetracking.document_level'))
                ->options([
                    '' => 'All',
                    'palika' => 'Palika',
                    'ward' => 'Ward',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('document_level', $value);
                    }
                }),
            SelectFilter::make("fiscal_year")
                ->options(
                    FiscalYear::query()
                        ->orderBy('year', 'desc')
                        ->pluck('year', 'id')
                        ->toArray()
                )
                ->filter(function (Builder $builder, $value) {
                    // Apply only if user selected a value
                    if ($value !== '') {
                        $builder->where('fiscal_year', (int)$value);
                    }
                }),
        ];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('filetracking::filetracking.chalani_no'), 'reg_no')
                ->format(
                    fn($value, $row, Column $column) => replaceNumbers($row->reg_no, App::getLocale() == 'ne' ? true : false),
                )
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('reg_no', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),
            Column::make(__('filetracking::filetracking.reg_date'), 'registration_date')
                ->format(function ($value) {
                    if ($value) {
                        $bsDate = $this->adToBs($value, 'yyyy-mm-dd');
                        return $this->convertEnglishToNepali($bsDate);
                    } else {
                        return "N/A";
                    }
                })
                ->sortable(),
            Column::make('पत्र संख्या', 'fiscalYear.year')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make("पत्र पाउने", 'recipient_name')
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('recipient_name', 'like', "%{$term}%");
                })
                ->collapseOnTablet(),
            Column::make(__('filetracking::filetracking.title'), 'title')
                ->sortable()
                ->collapseOnTablet(),
            // Column::make(__('filetracking::filetracking.receipent_details'), "applicant_mobile_no")
            //     ->label(function ($row) {
            //         $recipient_name = User::find($row->recipient_name)->name ?? $row->recipient_name;
            //         $recipient_department = Branch::find($row->recipient_department)->title ?? $row->recipient_department;

            //         $recipient_position = $row->recipient_position;
            //         return
            //             $row->recipient_position ? "
            //             <div> {$recipient_department} | {$recipient_position}</div>
            //         " : " <div> {$recipient_department} </div>";
            //     })
            //     ->sortable()
            //     ->html(),
            Column::make(__('filetracking::filetracking.signee_name'), 'signee_name')
                ->label(function ($row) {
                    // Always get the signee name
                    $signee_name = \App\Models\User::find($row->signee_name)?->name ?? $row->signee_name;

                    $rawDepartment = $row->signee_department;
                    $signee_position = $row->signee_position;

                    $departmentTitle = null;

                    if ($rawDepartment && preg_match('/^(.*)_(\d+)$/', $rawDepartment, $matches)) {
                        $departmentClass = $matches[1];
                        $departmentId = $matches[2];

                        try {
                            if (class_exists($departmentClass)) {
                                $department = $departmentClass::find($departmentId);

                                if ($department instanceof \Src\Wards\Models\Ward) {
                                    $departmentTitle = $department->ward_name_ne ?? 'वडा (नाम नभएको)';
                                } elseif ($department instanceof \Src\Employees\Models\Branch) {
                                    $departmentTitle = $department->title ?? 'शाखा (नाम नभएको)';
                                } else {
                                    $departmentTitle = method_exists($department, 'getTitle')
                                        ? $department->getTitle()
                                        : class_basename($departmentClass);
                                }
                            } else {
                                $departmentTitle = 'Class Not Found';
                            }
                        } catch (\Throwable $e) {
                            $departmentTitle = 'Error';
                        }
                    }
                    $details = [];

                    $details[] = "<strong>{$signee_name}</strong>";

                    if ($departmentTitle || $signee_position) {
                        $subInfo = $departmentTitle ?? '';
                        if ($signee_position) {
                            $subInfo .= ($subInfo ? ' | ' : '') . $signee_position;
                        }
                        $details[] = "<small>{$subInfo}</small>";
                    }

                    return implode('<br>', $details);
                })
                ->sortable()
                ->html(),


            Column::make(__('filetracking::filetracking.chalani_sender_medium'), "sender_medium")
                ->sortable()
                ->collapseOnTablet()
                ->label(function ($row) {
                    return SenderMediumEnum::tryFrom($row?->sender_medium)?->nepaliLabel()
                        ?? SenderMediumEnum::THROUGH_PERSONAL->nepaliLabel();
                }),
        ];
        if (can('chalani update') || can('chalani delete')) {
            $actionsColumn = Column::make(__('filetracking::filetracking.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';

                if (can('chalani update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('chalani delete')) {
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
        if (!can('chalani update')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.chalani.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('chalani delete')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new FileRecordAdminService();
        $service->delete(FileRecord::findOrFail($id));
        $this->successFlash(__('filetracking::filetracking.file_record_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('chalani delete')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new FileRecordAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new FileRecordsExport($records), 'file_records.xlsx');
    }
}
