<?php

namespace Src\Settings\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Settings\Models\Form;
use Src\Settings\Service\FormAdminService;

class FormTable extends DataTableComponent
{
    use SessionFlash;

    protected $model = Form::class;

    public $modules;

    public $moduleCount;
    public $path;

    public function mount($modules)
    {
        $this->modules = $modules;
        $this->path = request()->url();
        $this->moduleCount = count($this->modules);
    }

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
        if ($this->moduleCount > 1) {
            $query = Form::query()
                ->orderBy('title', 'desc')
                ->select('module')
                ->whereNull('deleted_by')
                ->whereNull('deleted_at');
        }elseif($this->moduleCount == 1){
            $query = Form::query()
                ->where('module',array_values($this->modules)[0])
                ->orderBy('title','desc')
                ->select('module')
                ->whereNull('deleted_by')
                ->whereNull('deleted_at');
        }
        return $query;

    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        if ($this->moduleCount > 1) {
        $columns = [
            Column::make(__('settings::settings.title'), "title")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('settings::settings.module'))
            ->label(function ($row) {
                return $row->module ?? '';
            })
            ->sortable()
            ->searchable()
            ->collapseOnTablet(),
    ];}
        elseif ($this->moduleCount === 1){
            $columns = [
                Column::make(__('settings::settings.title'), "title")->sortable()->searchable()->collapseOnTablet()
                    ->sortable()
                    ->searchable()
                    ->collapseOnTablet(),
                ];
        }

        if (can('form edit') || can('form delete')) {
            $actionsColumn = Column::make(__('settings::settings.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('form edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-pencil"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('form edit')) {
                    $edit = '<button class="btn btn-info btn-sm" wire:click="template(' . $row->id . ')" ><i class="bx bx-file"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('form delete')) {
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
        if (!can('form edit')) {
            self::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
            return false;
        }


        foreach ($this->modules as $key => $module) {
            if (str_contains(strtolower($this->path), strtolower($module))) {
                $moduleName = Str::before(Str::after($this->path, 'admin/'), '/');
                return redirect()->route( 'admin.'. $moduleName . '.form.edit', ['id' => $id]);
                break;
            }
        }
//        dd('no module');
        return redirect()->route('admin.setting.form.edit', ['id' => $id ]);
    }

    public function template($id)
    {
        if (!can('form edit')) {
            self::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
            return false;
        }
        foreach ($this->modules as $key => $module) {
            if (str_contains(strtolower($this->path), strtolower($module))) {
                $moduleName = Str::before(Str::after($this->path, 'admin/'), '/');
                return redirect()->route( 'admin.'. $moduleName . '.form.template', ['id' => $id]);
                break;
            }
        }
        return redirect()->route('admin.setting.form.template', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('form delete')) {
            self::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
            return false;
        }
        $service = new FormAdminService();
        $service->delete(Form::findOrFail($id));
        $this->successFlash(__('settings::settings.form__deleted_successfully'));
    }

    public function deleteSelected()
    {
        if (!can('form delete')) {
            self::WARNING_FLASH(__('settings::settings.you_cannot_perform_this_action'));
            return false;
        }
        $service = new FormAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
}
