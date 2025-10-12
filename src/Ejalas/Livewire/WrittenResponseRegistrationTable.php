<?php

namespace Src\Ejalas\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Ejalas\Exports\WrittenResponseRegistrationsExport;
use Src\Ejalas\Models\WrittenResponseRegistration;
use Src\Ejalas\Service\WrittenResponseRegistrationAdminService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class WrittenResponseRegistrationTable extends DataTableComponent
{
    use SessionFlash;
    protected $model = WrittenResponseRegistration::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('jms_written_response_registrations.id')
            ->setTableAttributes([
                'class' => "table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['jms_written_response_registrations.id'])
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
        return WrittenResponseRegistration::query()
            ->select('*')
            ->with('complaintRegistration')
            ->where('jms_written_response_registrations.deleted_at', null)
            ->where('jms_written_response_registrations.deleted_by', null)
            ->orderBy('jms_written_response_registrations.created_at', 'DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
        $columns = [
            Column::make(__('ejalas::ejalas.complaint_no'), "complaintRegistration.reg_no")->sortable()->searchable()->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.registration_detail'))->label(function ($row) {
                $registrationNo = $row->response_registration_no ? $row->response_registration_no : __('ejalas::ejalas.na');
                $registrationDate = $row->registration_date ? $row->registration_date : __('ejalas::ejalas.na');
                return "
                 <strong>" . __('ejalas::ejalas.registration_no') . ":</strong> {$registrationNo} <br>
                    <strong>" . __('ejalas::ejalas.registration_date') . ":</strong> {$registrationDate} <br>
                ";
            })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.fee_details'))
                ->label(function ($row) {
                    $feeAmount = $row->fee_amount ? $row->fee_amount : __('ejalas::ejalas.na');
                    $feeReceiptNo = $row->fee_receipt_no ? $row->fee_receipt_no : __('ejalas::ejalas.na');
                    $feePaidDate = $row->fee_paid_date ? $row->fee_paid_date : __('ejalas::ejalas.na');
                    return "
                    <strong>" . __('ejalas::ejalas.amount') . ":</strong> {$feeAmount} <br>
                    <strong>" . __('ejalas::ejalas.receipt_no') . ":</strong> {$feeReceiptNo} <br>
                    <strong>" . __('ejalas::ejalas.paid_date') . ":</strong> {$feePaidDate}
                ";
                })
                ->html()
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make(__('ejalas::ejalas.status'), "status")->sortable()->searchable()->collapseOnTablet(),
        ];
        if (can('jms_judicial_management edit') || can('jms_judicial_management delete') || can('jms_judicial_management print')) {
            $actionsColumn = Column::make(__('ejalas::ejalas.actions'))->label(function ($row, Column $column) {
                $buttons = '';

                if (can('jms_judicial_management edit')) {
                    $edit = '<button class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')" ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

                if (can('jms_judicial_management delete')) {
                    $delete = '<button type="button" class="btn btn-danger btn-sm me-1" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                if (can('jms_judicial_management print')) {
                    $preview = '<button type="button" class="btn btn-info btn-sm" wire:click="preview(' . $row->id . ')"><i class="bx bx-file"></i></button>';
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
        return redirect()->route('admin.ejalas.written_response_registrations.edit', ['id' => $id]);
    }
    public function delete($id)
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WrittenResponseRegistrationAdminService();
        $service->delete(WrittenResponseRegistration::findOrFail($id));
        $this->successFlash(__('ejalas::ejalas.written_response_registration_deleted_successfully'));
    }
    public function deleteSelected()
    {
        if (!can('jms_judicial_management delete')) {
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new WrittenResponseRegistrationAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected()
    {
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new WrittenResponseRegistrationsExport($records), 'written_response_registrations.xlsx');
    }
    public function preview($id)
    {
        return redirect()->route('admin.ejalas.written_response_registrations.preview', ['id' => $id]);
    }
}
