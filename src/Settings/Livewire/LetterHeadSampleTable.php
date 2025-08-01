<?php

namespace Src\Settings\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Settings\Models\LetterHeadSample;
use Src\Settings\Service\LetterHeadSampleAdminService;

class LetterHeadSampleTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = LetterHeadSample::class;
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
            ->setBulkActionConfirms([
                'delete',
            ]);
    }

    public function builder(): Builder
    {
        return LetterHeadSample::query()
            ->orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->orderBy('created_at', 'desc');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('settings::settings.name'), "name")->html()->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('settings::settings.slug'), "slug")->html()->sortable()->searchable()->collapseOnTablet(),
        ];

        if (can('letter_head_sample_update') || can('letter_head_sample_delete')) {
            $actionsColumn = Column::make(__('settings::settings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('letter_head_sample_update')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('letter_head_sample_delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
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
        if (!can('letter_head_sample_update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.letter-head-sample.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('letter_head_sample_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LetterHeadSampleAdminService();
        $service->delete(LetterHeadSample::findOrFail($id));
        $this->successFlash("Letter Head Sample Deleted Successfully");
    }

    public function deleteSelected()
    {
        if (!can('letter_head_sample_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LetterHeadSampleAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
}
