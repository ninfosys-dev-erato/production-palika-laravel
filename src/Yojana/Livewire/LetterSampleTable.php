<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Exports\LetterSamplesExport;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Service\LetterSampleAdminService;

class LetterSampleTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = LetterSample::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_letter_samples.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_letter_samples.id'])
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
        return LetterSample::query()
            ->with(['implementationMethod', 'letterType'])
            ->where('pln_letter_samples.deleted_at', null)
            ->where('pln_letter_samples.deleted_by', null)
            ->orderBy('pln_letter_samples.created_at', 'DESC');
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('yojana::yojana.letter_type'), "letter_type")
                ->format(function($value){
                    return $value?->label() ?? "";
                })
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.implementation_method'), "implementationMethod.title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.name'), "name")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('yojana::yojana.subject'), "subject")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('plan_basic_settings edit') || can('plan_basic_settings delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan_basic_settings edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('plan_basic_settings delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;
    }
    public function refresh() {}
    public function edit($id)
    {
        if (!can('plan_basic_settings edit')) {
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        return redirect()->route('admin.letter_samples.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LetterSampleAdminService();
        $service->delete(LetterSample::findOrFail($id));
        $this->successFlash(__('yojana::yojana.letter_sample_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('plan_basic_settings delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LetterSampleAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new LetterSamplesExport($records), 'letter_samples.xlsx');
    }
}
