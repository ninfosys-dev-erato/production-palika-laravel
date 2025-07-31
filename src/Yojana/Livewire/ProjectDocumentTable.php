<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\ProjectDocumentsExport;
use Src\Yojana\Models\ProjectDocument;
use Src\Yojana\Service\ProjectDocumentAdminService;

class ProjectDocumentTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = ProjectDocument::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['id'])
            ->setBulkActionsDisabled()
            ->setPerPageAccepted([10, 25, 50, 100,500])
            ->setSelectAllEnabled()
            ->setRefreshMethod('refresh')
            ->setBulkActionConfirms([
                'delete',
            ]);
    }
    public function builder(): Builder
    {
        return ProjectDocument::query()
            ->where('deleted_at',null)
            ->where('deleted_by',null)
           ->orderBy('created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
            Column::make("Project Id", "project_id") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Document Name", "document_name") ->sortable()->searchable()->collapseOnTablet(),
Column::make("Data", "data") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('project_documents edit') || can('project_documents delete')) {
            $actionsColumn = Column::make('Actions')->label(function ($row, Column $column) {
                $buttons = '';

                if (can('project_documents edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="fa fa-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('project_documents delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons;
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('project_documents edit')){
               SessionFlash::WARNING_FLASH('You Cannot Perform this action');
               return false;
        }
        return redirect()->route('admin.project_documents.edit',['id'=>$id]);
    }
    public function delete($id)
    {
        if(!can('project_documents delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ProjectDocumentAdminService();
        $service->delete(ProjectDocument::findOrFail($id));
        $this->successFlash("Project Document Deleted Successfully");
    }
    public function deleteSelected(){
        if(!can('project_documents delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ProjectDocumentAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ProjectDocumentsExport($records), 'project_documents.xlsx');
    }
}
