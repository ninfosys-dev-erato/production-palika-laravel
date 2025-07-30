<?php

namespace Src\FileTracking\Livewire;

use App\Facades\GlobalFacade;
use App\Traits\HelperDate;
use Illuminate\Contracts\View\View;
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
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class DartaTable extends DataTableComponent
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
            ->setAdditionalSelects(['tbl_file_records.id', 'signee_department'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100, 500])
            ->setSelectAllEnabled()
            ->setSecondaryHeaderStatus(true)
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
        $this->setSearchLive();
        $this->setSearchPlaceholder(__('Enter Darta No / Letter Sender`s Name'));
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($column->isField('total') && $row->total < 1000) {
                return [
                    'class' => 'text-sm',
                ];
            }

            return [];
        });
    }
    public function mount()
    {
        $currentFiscalYear =  key(getSettingWithKey('fiscal-year'));
        $this->setFilter('fiscal_year', $currentFiscalYear);
    }
    public function builder(): Builder
    {
        $query = FileRecord::query()
            ->with(['fiscalYear', 'recipient', 'farsyaut']) // minimal necessary relations
            ->select([
                'tbl_file_records.id',
                'tbl_file_records.reg_no',
                'tbl_file_records.sender_id',
                'tbl_file_records.sender_type',
                'tbl_file_records.title',
                'tbl_file_records.departments',
                'tbl_file_records.recipient_type',
                'tbl_file_records.recipient_id',
                'tbl_file_records.farsyaut_type',
                'tbl_file_records.farsyaut_id',
                'tbl_file_records.recipient_department',
                'tbl_file_records.registration_date',
                'tbl_file_records.sender_document_number',
                'tbl_file_records.received_date',
                'tbl_file_records.applicant_name',
                'tbl_file_records.applicant_address',
                'tbl_file_records.fiscal_year',
                'tbl_file_records.branch_id',
                'tbl_file_records.ward',
                'tbl_file_records.deleted_at',
                'tbl_file_records.deleted_by',
                'tbl_file_records.is_chalani',
                'tbl_file_records.created_at',
            ])
            ->whereNull('tbl_file_records.deleted_at')
            ->whereNull('tbl_file_records.deleted_by')
            ->where('tbl_file_records.is_chalani', false)
            ->whereNotNull('tbl_file_records.reg_no')
            ->orderByDesc('tbl_file_records.created_at');

        $user = auth()->user()->fresh();
        $departmentId = GlobalFacade::department();
        $ward = GlobalFacade::ward();

        if (!isSuperAdmin()) {
            if (!$departmentId && !$ward) {
                return $query->where('tbl_file_records.id', -1); // No access
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
        $wards = Ward::whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->get()
            ->mapWithKeys(function ($ward) {
                return [
                    get_class($ward) . '::find(' . $ward->id . ')' => $ward->display_name,
                ];
            })
            ->toArray();

        $branches = Branch::whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->get()
            ->mapWithKeys(function ($branch) {
                return [
                    get_class($branch) . '::find(' . $branch->id . ')' => $branch->display_name,
                ];
            })
            ->toArray();
        return [
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
            SelectFilter::make('department')
                ->options(
                    [
                        '' => 'All',
                        'शाखा (Branches)' => $branches,
                        'वडा (Wards)' => $wards,
                    ]

                )
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $recipient = eval("return " . $value . ';');
                        $class = get_class($recipient);
                        $builder->where('recipient_id', $recipient->id)
                            ->where('recipient_type', $class);
                    }
                }),
            SelectFilter::make('farsyaut_type')
                ->options(
                    [
                        '' => 'All',
                        'शाखा (Branches)' => $branches,
                        'वडा (Wards)' => $wards,
                    ]
                )
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $recipient = eval("return " . $value . ';');
                        $class = get_class($recipient);
                        $builder->where('farsyaut_id', $recipient->id)
                            ->where('farsyaut_type', $class);
                    }
                }),
            SelectFilter::make('fiscal_year')
                ->options(
                    FiscalYear::query()
                        ->orderBy('year', 'desc')
                        ->pluck('year', 'id')
                        ->toArray()
                )
                ->filter(function (Builder $builder, $value) {

                    if ($value !== '') {
                        $builder->where('fiscal_year', (int)$value);
                    } else {
                        $builder->where('fiscal_year', FiscalYear::latest('year')->value('id'));
                    }
                }),


        ];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('filetracking::filetracking.reg_no'), 'reg_no')
                ->format(
                    fn($value, $row, Column $column) => replaceNumbers($row->reg_no, App::getLocale() == 'ne' ? true : false),
                )
                ->searchable(function ($builder, $term) {
                    $builder->orWhere('reg_no', 'like', "%{$term}%");
                })
                ->sortable(),
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
            Column::make('पत्र संख्या', 'fiscalYear.year'),
            Column::make('च.नं', 'sender_document_number'),
            Column::make('पत्र प्राप्त मिति', 'received_date')
                ->format(function ($value) {
                    if ($value) {
                        return $this->convertEnglishToNepali($value);
                    } else {
                        return "N/A";
                    }
                })
                ->sortable(),
            Column::make(__('filetracking::filetracking.letter_sender_person_or_organization_name'), 'applicant_name')
                // ->setCustomSlug('sender_id')
                // ->label(function ($row) {
                //     return optional($row->sender)->name ?? 'N/A';
                // })
                // ->searchable(function ($builder, $term) {
                //     $builder->orWhereHas('sender', function ($query) use ($term) {
                //         $query->where('name', 'like', "%{$term}%");
                //     });
                // })
                ->sortable(),

            Column::make(__('filetracking::filetracking.address'), 'applicant_address')
                ->sortable(),
            Column::make(__('filetracking::filetracking.subject'), 'title')
                ->sortable(),


            Column::make(__('बुझाउने शाखा वा फाँट'))
                ->label(function ($row) {
                    $recipient = $row->recipient;

                    if (is_null($recipient)) {
                        return $row->recipient_department ?? '';
                    }

                    return match (true) {
                        $recipient instanceof \Src\Wards\Models\Ward => $recipient->ward_name_ne ?? '',
                        $recipient instanceof \Src\Employees\Models\Branch => $recipient->title ?? '',
                        default => '',
                    };
                })
                ->sortable(),

            Column::make(__('filetracking::filetracking.farsyuat_department'))
                ->label(function ($row) {
                    $farsyaut = $row->farsyaut;

                    if (is_null($farsyaut)) {
                        return $row->recipient_department ?? '';
                    }

                    return match (true) {
                        $farsyaut instanceof \Src\Wards\Models\Ward => $farsyaut->ward_name_ne ?? '',
                        $farsyaut instanceof \Src\Employees\Models\Branch => $farsyaut->title ?? '',
                        default => '',
                    };
                })
                ->sortable(),

        ];
        // if (can('darta update') || can('darta delete')) {
            $actionsColumn = Column::make(__('filetracking::filetracking.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group " role="group">';

                // if (can('darta access')) {
                    $view = '<button class="btn btn-success btn-sm" wire:click="view(' . $row->id . ')" ><i class="bx bx-show"></i></button>&nbsp;';
                    $buttons .= $view;
                // }
                if (can('darta update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('darta delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons . "</div>";
            })->html();

            $columns[] = $actionsColumn;
        // }

        return $columns;
    }

    public function render(): View
    {
        return view('FileTracking::livewire.table.file-tracking-table', [
            'columns'   => $this->columns(),
        ]);
    }

    public function refresh() {}
    public function edit($id)
    {
        if (!can('darta update')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.register_files.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('darta delete')) {
            SessionFlash::WARNING_FLASH(__('filetracking::filetracking.you_cannot_perform_this_action'));
            return false;
        }
        $service = new FileRecordAdminService();
        $service->delete(FileRecord::findOrFail($id));
        $this->successFlash(__('filetracking::filetracking.file_record_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('darta delete')) {
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
    public function view($id)
    {
        
        return redirect()->route('admin.register_files.show',  $id);
    }
}
