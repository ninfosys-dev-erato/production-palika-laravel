<?php

namespace Src\Pages\Livewire;


use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Src\Pages\Exports\PagesExport;
use Src\Pages\Models\Page;
use Src\Pages\Service\PageAdminService;

class PageTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Page::class;
    public array $bulkActions = [

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
        return Page::query()
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
            Column::make(__('pages::pages.title'), "title")->sortable()->searchable()->collapseOnTablet(),
//            Column::make("Content", "content")->html()->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('pages::pages.slug'), "slug")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('page_update') || can('page_delete')) {
            $actionsColumn = Column::make(__('pages::pages.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('page_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('page_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }

    public function refresh()
    {
    }

    public function edit($id)
    {
        if (!can('page_update')) {
            SessionFlash::WARNING_FLASH(__('You Cannot Perform this action'));
            return false;
        }
        return redirect()->route('admin.pages.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('page_delete')) {
            SessionFlash::WARNING_FLASH(__('You Cannot Perform this action'));
            return false;
        }
        $service = new PageAdminService();
        $service->delete(Page::findOrFail($id));
        $this->successFlash(__("page::page.page_deleted_successfully"));
    }

    public function deleteSelected()
    {
        if (!can('page_delete')) {
            SessionFlash::WARNING_FLASH(__('You Cannot Perform this action'));
            return false;
        }
        $service = new PageAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }

    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new PagesExport($records), 'pages.xlsx');
    }
}
