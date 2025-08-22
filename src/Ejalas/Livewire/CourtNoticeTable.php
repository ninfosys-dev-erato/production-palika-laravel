<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\CourtNoticesExport;
use Src\Ejalas\Models\CourtNotice;
use Src\Ejalas\Service\CourtNoticeAdminService;

class CourtNoticeTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;
    protected $model = CourtNotice::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_court_notices.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_court_notices.id'])
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
        return CourtNotice::query()
            ->with(['complaintRegistration', 'fiscalYear', 'complaintRegistration.parties', 'complaintRegistration.disputeMatter', 'complaintRegistration.disputeMatter.disputeArea'])
            ->select('*')
            ->where('jms_court_notices.deleted_at', null)
            ->where('jms_court_notices.deleted_by', null)
            ->orderBy('jms_court_notices.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [


            Column::make(__('ejalas::ejalas.notice_details'))->label(function ($row) {
                $noticeNo = $row->notice_no ?? "N/A";
                $noticeDate = $row->notice_date ?? "N/A";
                $referenceNo = $row->reference_no ?? "N/A";
                return "
                    <strong>" . (__('ejalas::ejalas.notice_no')) . ":" . "</strong> {$noticeNo} <br>
                    <strong>" . (__('ejalas::ejalas.notice_date')) . ":" . "</strong> {$noticeDate} <br>
                    <strong>" . (__('ejalas::ejalas.ejalash_referenceno')) . ":" . "</strong> {$referenceNo}
                ";
            })->html()->sortable()->searchable()->collapseOnTablet(),

            // Column::make(__('ejalas::ejalas.notice_no'), "notice_no")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.notice_date'), "notice_date")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('ejalas::ejalas.reference_no'), "reference_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),

            Column::make(__('ejalas::ejalas.notice_time'), "notice_time")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.complainer'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Complainer')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),
            Column::make(__('ejalas::ejalas.defender'))
                ->label(
                    fn($row) => $row->complaintRegistration?->parties
                        ->filter(fn($party) => $party->pivot->type === 'Defender')
                        ->pluck('name')
                        ->implode(', ') ?: 'N/A'
                ),
            Column::make(__('ejalas::ejalas.dispute_area'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 90px;' title='{$row->complaintRegistration?->disputeMatter?->disputeArea?->title}'>
                                {$row->complaintRegistration?->disputeMatter?->disputeArea?->title}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.dispute_subject'))->label(function ($row) {
                return "<div class='text-truncate d-inline-block' style='max-width: 100px;' title='{$row->complaintRegistration?->disputeMatter?->title}'>
                                {$row->complaintRegistration?->disputeMatter?->title}
                            </div>";
            })->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),




        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-primary btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
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
        if (!can('jms_judicial_management edit')) {
            SessionFlash::WARNING_FLASH(__('ejalas::ejalas.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.ejalas.court_notices.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CourtNoticeAdminService();
        $service->delete(CourtNotice::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.court_notice_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new CourtNoticeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new CourtNoticesExport($records), 'court_notices.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.court_notices.preview', ['id' => $id]);
    }
}
