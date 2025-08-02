<?php

namespace Src\DigitalBoard\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\DigitalBoard\Exports\VideosExport;
use Src\DigitalBoard\Models\Video;
use Src\DigitalBoard\Service\VideoAdminService;

class VideoTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = Video::class;

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
        return Video::query()
            ->with('wards')
            ->select('url')
            ->where('deleted_at', null)
            ->where('deleted_by', null)
            ->orderBy('created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('digitalboard::digitalboard.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            // Column::make(__('digitalboard::digitalboard.url'), "url")
            //     ->label(function ($row) {
            //         if (empty($row->url)) {
            //             return '<span class="text-muted">N/A</span>';
            //         }

            //         $urlLink = $row->url;
            //         return '<a href="' . $urlLink . '" target="_blank" class="btn btn-sm btn-info">' . __('digitalboard::digitalboard.view') . '</a>';
            //     })
            //     ->html()
            //     ->sortable()
            //     ->searchable()
            //     ->collapseOnTablet(),
            Column::make(__('digitalboard::digitalboard.can_show_on_palika'), 'can_show_on_admin')
                ->format(function ($value, $row) {
                    $canShowOnAdmin = $row->can_show_on_admin == 1;
                    return view('livewire-tables.includes.columns.status_switch', [
                        'rowId' => $row->id,
                        'isActive' => $canShowOnAdmin
                    ]);
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('digitalboard::digitalboard.wards'))
                ->label(function ($row) {
                    return $row->wards->isEmpty() ? 'N/A' : $row->wards->pluck('ward')->implode(', ');
                })
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
        ];
        if (can('digital_board edit') || can('digital_board delete')) {
            $actionsColumn = Column::make(__('digitalboard::digitalboard.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('digital_board edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('digital_board delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>&nbsp;';
                    $buttons .= $delete;
                }

                if (!empty($row->url)) {
                    $urlButton = '<a href="' . $row->url . '" target="_blank" class="btn btn-info btn-sm"><i class="bx bx-link"></i></a>';
                } else {
                    $urlButton = '<button class="btn btn-secondary btn-sm disabled" style="filter: grayscale(100%);"><i class="bx bx-link"></i></button>';
                }
                $buttons .= $urlButton;

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('digital_board edit')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.digital_board.videos.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VideoAdminService();
        DB::beginTransaction();

        try {
            $deletedVideo = $service->delete(Video::findOrFail($id));
            $service->deletevideoWards($deletedVideo);
            DB::commit();
            $this->successFlash(__('digitalboard::digitalboard.video_deleted_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    public function deleteSelected()
    {
        if (!can('digital_board delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new VideoAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new VideosExport($records), 'videos.xlsx');
    }

    public function toggleStatus($id)
    {
        $video = Video::findOrFail($id);
        $service = new VideoAdminService();
        $service->toggleCanShowOnAdmin($video);
    }
}
