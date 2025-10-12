<?php

namespace Src\Ejalas\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\SessionFlash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Traits\Columns\IsSearchable;
use Src\Ejalas\Exports\ComplaintRegistrationsExport;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Service\ComplaintRegistrationAdminService;

class AnusuchiFormTable extends DataTableComponent
{
    use SessionFlash, IsSearchable;

    protected $model = ComplaintRegistration::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('jms_complaint_registrations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_complaint_registrations.id'])
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
        return ComplaintRegistration::query()
            ->with(['parties'])
            ->select('*')
            ->where('jms_complaint_registrations.deleted_at', null)
            ->where('jms_complaint_registrations.deleted_by', null)
            ->orderBy('jms_complaint_registrations.created_at', 'DESC');
    }

    public function filters(): array
    {
        return [];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_registration'), "reg_no")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            
            Column::make(__('ejalas::ejalas.parties'))
                ->label(function ($row) {
                    // Fetch related parties using the many-to-many relationship
                    $defenders = $row->parties()->where('complaint_party.type', 'Defender')->pluck('name')->toArray();
                    $complainers = $row->parties()->where('complaint_party.type', 'Complainer')->pluck('name')->toArray();
                    
                    $allParties = array_merge($complainers, $defenders);
                    return implode(', ', $allParties);
                })
                ->sortable()
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('parties', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%");
                    });
                })
                ->collapseOnTablet(),
        ];


            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
    
                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-info btn-sm me-1" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
                    $buttons .= $preview;
                }
                return $buttons . "</div>";
            })->html();
            $columns[] = $actionsColumn;
       
        return $columns;
    }

    public function refresh() {}

 public function preview($id)
 {
    return redirect()->route('admin.ejalas.anusuchi-form.preview', ['id' => $id]);
 }



}
