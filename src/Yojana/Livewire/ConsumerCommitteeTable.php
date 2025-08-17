<?php

namespace Src\Yojana\Livewire;


use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Exports\ConsumerCommitteesExport;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Service\ConsumerCommitteeAdminService;
use Src\Yojana\Traits\YojanaTemplate;

use Src\Yojana\Service\WorkOrderAdminService;

class ConsumerCommitteeTable extends DataTableComponent
{
    use SessionFlash,YojanaTemplate;

    protected $model = ConsumerCommittee::class;
    public array $bulkActions = [
        'exportSelected' => 'Export',
        'deleteSelected' => 'Delete',
    ];
    public function configure(): void
    {
        $this->setPrimaryKey('pln_consumer_committee.id')
            ->setTableAttributes([
                'class' =>"table table-bordered table-hover dataTable dtr-inline"
            ])
            ->setAdditionalSelects(['pln_consumer_committee.id'])
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
        return ConsumerCommittee::query()
            ->with('committeeType','ward','bank')
            ->select('*')
            ->where('pln_consumer_committee.deleted_at',null)
            ->where('pln_consumer_committee.deleted_by',null)
           ->orderBy('pln_consumer_committee.created_at','DESC'); // Select some things
    }
    public function filters(): array
    {
        return [];
    }
    public function columns(): array
    {
     $columns = [
         Column::make(__('yojana::yojana.registration_detail'))
             ->label(function ($row) {
                 $registrationNumber = $row->registration_number ?? "N/A";
                 $formationDate = $row->formation_date ?? "N/A";

                 return '<strong>' . __('yojana::yojana.registration_number') . ':</strong> ' . $registrationNumber . '<br>' .
                     '<strong>' . __('yojana::yojana.date') . ':</strong> ' . $formationDate;
             })
             ->html()
             ->sortable()
             ->searchable()
             ->collapseOnTablet(),

         Column::make(__('yojana::yojana.committee_type'), app()->getLocale() !== 'ne' ? 'committeeType.name_en' : 'committeeType.name') ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.name'), "name") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.ward'), app()->getLocale() !== 'ne' ? "ward.ward_name_en":"ward.ward_name_ne") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.address'), "address") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.creating_body'), "creating_body") ->sortable()->searchable()->collapseOnTablet(),
Column::make(__('yojana::yojana.number_of_attendees'), "number_of_attendees") ->sortable()->searchable()->collapseOnTablet()->format( fn ($value) => replaceNumbersWithLocale($value, true)),
Column::make(__('yojana::yojana.bank'), 'bank.title') ->sortable()->searchable()->collapseOnTablet(),
BooleanColumn::make(__('yojana::yojana.formation_minute'), "formation_minute") ->sortable()->searchable()->collapseOnTablet(),
     ];
        if (can('plan_committee_settings edit') || can('plan_committee_settings delete')) {
            $actionsColumn = Column::make(__('yojana::yojana.actions'))->label(function ($row, Column $column) {
                $buttons = '<div class="btn-group" role="group" >';
                if (can('plan_committee_settings edit')) {
                    $edit = '<button wire:ignore class="btn btn-primary btn-sm" wire:click="edit(' . $row->id . ')"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="' . __('yojana::yojana.edit') . '"
                            ><i class="bx bx-edit"></i></button>&nbsp;';
                    $buttons .= $edit;
                }

//                if (can('plan_committee_settings edit')) {
//                    $print = '<button class="btn btn-info btn-sm" wire:click="printRegistrationCertificate(' . $row->id . ')" ><i class="bx bx-file"></i></button>&nbsp;';
//                    $buttons .= $print;
//                }
//
//                if (can('plan_committee_settings edit')) {
//                    $print = '<button class="btn btn-info btn-sm" wire:click="printAccountOperationLetter(' . $row->id . ')" ><i class="bx bx-file"></i></button>&nbsp;';
//                    $buttons .= $print;
//                }
//
//                if (can('plan_committee_settings edit')) {
//                    $print = '<button class="btn btn-info btn-sm" wire:click="printAccountClosureLetter(' . $row->id . ')" ><i class="bx bx-file"></i></button>&nbsp;';
//                    $buttons .= $print;
//                }

                if (can('plan_committee_settings edit')) {
                    $buttons .= '
        <button
            class="btn btn-info btn-sm" wire:ignore
            wire:click="printRegistrationCertificate(' . $row->id . ')"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="' . __('yojana::yojana.print_registration_certificate') . '"
        >
            <i class="bx bx-file"></i>
        </button>&nbsp;

        <button
            class="btn btn-info btn-sm" wire:ignore
            wire:click="printAccountOperationLetter(' . $row->id . ')"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="' . __('yojana::yojana.print_account_operation_letter') . '"
        >
            <i class="bx bx-file"></i>
        </button>&nbsp;

        <button
            class="btn btn-info btn-sm" wire:ignore
            wire:click="printAccountClosureLetter(' . $row->id . ')"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="' . __('yojana::yojana.print_account_closure_letter') . '"

        >
            <i class="bx bx-file"></i>
        </button>&nbsp;
    ';
                }

                if (can('plan_committee_settings delete')) {
                    $delete = '<button wire:ignore type="button" class="btn btn-danger btn-sm" wire:confirm="Are you sure you want to delete this record?" wire:click="delete(' . $row->id . ')"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="' . __('yojana::yojana.delete') . '"
                                ><i class="bx bx-trash"></i></button>';
                    $buttons .= $delete;
                }

                return $buttons."</div>";
            })->html();

            $columns[] = $actionsColumn;
        }

        return $columns;

    }
    public function refresh(){}
    public function edit($id)
    {
        if(!can('plan_committee_settings edit')){
               SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
               return false;
        }
        return redirect()->route('admin.consumer_committees.edit',['id'=>$id]);
    }

    public function delete($id)
    {
        if(!can('plan_committee_settings delete')){
                SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                return false;
        }
        $service = new ConsumerCommitteeAdminService();
        $service->delete(ConsumerCommittee::findOrFail($id));
        $this->successFlash(__('yojana::yojana.consumer_committee_deleted_successfully'));
    }
    public function deleteSelected(){
        if(!can('plan_committee_settings delete')){
                    SessionFlash::WARNING_FLASH('You Cannot Perform this action');
                    return false;
        }
        $service = new ConsumerCommitteeAdminService();
        $service->collectionDelete($this->getSelected());
        $this->clearSelected();
    }
    public function exportSelected(){
        $records = $this->getSelected();
        $this->clearSelected();
        return Excel::download(new ConsumerCommitteesExport($records), 'consumer_committees.xlsx');
    }

    public function printRegistrationCertificate($id)
    {
        if(!can('plan_committee_settings edit')){
        SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
        return false;
        }
        $letterType = LetterTypes::RegistrationCertificate->value;
        $this->printLetter($letterType, $id);
    }
    public function printAccountOperationLetter($id)
    {
        if(!can('plan_committee_settings edit')){
        SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
        return false;
        }
        $letterType = LetterTypes::AccountOperationRecommendation->value;
        $this->printLetter($letterType, $id);
    }

    public function printAccountClosureLetter($id)
    {
        if(!can('plan_committee_settings edit')){
        SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
        return false;
        }
        $letterType = LetterTypes::AccountClosureRecommendation->value;
        $this->printLetter($letterType, $id);
    }

    public function printLetter($letterType,$id)
    {
        if(!can('plan_committee_settings edit')){
            SessionFlash::WARNING_FLASH(__('yojana::yojana.you_cannot_perform_this_action'));
            return false;
        }
        $letterSample = LetterSample::where('letter_type', $letterType)->first();

        if (!$letterSample) {
            $this->errorFlash("Letter Sample Not Found.");
            return null; // or handle gracefully
        }

        $consumerCommittee = ConsumerCommittee::whereNull('deleted_at')->find($id);
        $consumerCommittee->load('ward');

        $letter = $consumerCommittee->{$letterType};


//        if ($letterType == LetterTypes::AccountOperationRecommendation){
//            $letter  = $consumerCommittee->account_operation_letter;
//        }
//        elseif ($letterType == LetterTypes::AccountClosureRecommendation){
//            $letter  = $consumerCommittee->account_closure_letter;
//        }

        if (!$letter) {
            $letterBody = $this->resolveTemplate($consumerCommittee, $letterSample) ?? "";
            $consumerCommittee->{$letterType} = $letterBody;
            $consumerCommittee->save();
        }
        $url = route('admin.consumer_committees.preview', ['id' => $consumerCommittee->id, 'letterType' => $letterType]);
        $this->dispatch('open-pdf-in-new-tab', url: $url, letterType: $letterType);


    }

}
