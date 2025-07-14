<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\LegalDocumentAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Models\LegalDocumentDetail;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\LegalDocumentAdminService;

class LegalDocumentForm extends Component
{
    use SessionFlash;

    public ?LegalDocument $legalDocument;
    public ?Action $action;
    public $complainRegistrations;
    public  $parties;
    public array $temporaryDetails = [];
    public array $legalDocumentDetail = [];
    public $editIndex = null;
    public array $deletedDetailIds = []; //saves id of data that user has clicked delete on the table

    public function rules(): array
    {
        return [
            'legalDocument.complaint_registration_id' => ['required'],
            'legalDocument.party_name' => ['nullable'],
            'legalDocument.document_writer_name' => ['nullable'],
            'legalDocument.document_date' => ['nullable'],
            'legalDocument.document_details' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.legal-document.form");
    }

    public function mount(LegalDocument $legalDocument, Action $action)
    {
        $this->legalDocument = $legalDocument;
        $this->action = $action;
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        if ($this->legalDocument) {
            $this->getComplaintRegistration();
        }

        if ($this->action === Action::UPDATE) {
            $this->temporaryDetails = $this->legalDocument->LegalDocumentDetail->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'statement_giver' => $detail->statement_giver,
                    'party_name' => $detail->party_name,
                    'document_writer_name' => $detail->document_writer_name,
                    'document_date' => $detail->document_date,
                    'document_details' => $detail->document_details,
                    'partyName' => Party::find($detail->party_name)?->name ?? 'N/A',
                ];
            })->toArray();
        }
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->legalDocument['complaint_registration_id'];


        $complaintData = ComplaintRegistration::with(['parties'])->find($complaintRegistrationId);

        if ($complaintData) {

            $this->parties = $complaintData->parties;
        } else {
            $this->parties = collect();
        }
    }


    public function save()
    {
        $this->validate();
        try {
            $dto = LegalDocumentAdminDto::fromLiveWireModel($this->legalDocument);
            $service = new LegalDocumentAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $legalDocument = $service->store($dto);
                    $this->addLegalDocumentDetail($legalDocument);
                    $this->successFlash(__('ejalas::ejalas.legal_document_created_successfully'));
                    return redirect()->route('admin.ejalas.legal_documents.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->legalDocument, $dto);
                    $this->addLegalDocumentDetail($this->legalDocument);
                    $this->successFlash(__('ejalas::ejalas.legal_document_updated_successfully'));
                    return redirect()->route('admin.ejalas.legal_documents.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.legal_documents.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function saveTemporaryDetail()
    {
        $this->validate([
            'legalDocumentDetail.document_date' => 'required',
            'legalDocumentDetail.party_name' => 'required',
            'legalDocumentDetail.document_writer_name' => 'required',
            'legalDocumentDetail.statement_giver' => 'required',
            'legalDocumentDetail.document_details' => 'required',
        ]);
        $partyName = Party::find($this->legalDocumentDetail['party_name'])->name ?? 'N/A'; //finds party name from the id saved in party_name

        $this->legalDocumentDetail['partyName'] = $partyName; //add name to the array

        if ($this->editIndex !== null) {
            // Update the existing detail
            $this->temporaryDetails[$this->editIndex] = $this->legalDocumentDetail;
            $this->editIndex = null;
        } else {
            $this->temporaryDetails[] = $this->legalDocumentDetail;
        }
        $this->legalDocumentDetail = [];

        $this->dispatch('close-modal');
        $this->successFlash(__('ejalas::ejalas.legal_document_detail_saved_successfully'));
    }
    public function editTemporaryDetail($index)
    {
        $this->editIndex = $index;

        $this->legalDocumentDetail = $this->temporaryDetails[$index];


        $this->dispatch('open-modal');
    }
    public function removeTemporaryDetail($index)
    {

        if (isset($this->temporaryDetails[$index]['id'])) {
            $this->deletedDetailIds[] = $this->temporaryDetails[$index]['id'];
        }
        unset($this->temporaryDetails[$index]);
        $this->temporaryDetails = array_values($this->temporaryDetails); // Reindex
        $this->successFlash(__('ejalas::ejalas.legal_document_detail_deleted_successfully'));
    }
    public function addLegalDocumentDetail(LegalDocument $legalDocument)
    {
        foreach ($this->temporaryDetails as $detail) {
            if (isset($detail['id'])) {
                $existing = LegalDocumentDetail::find($detail['id']);
                if ($existing) {
                    $existing->update([
                        'statement_giver' => $detail['statement_giver'],
                        'party_name' => $detail['party_name'],
                        'document_writer_name' => $detail['document_writer_name'],
                        'document_date' => $detail['document_date'],
                        'document_details' => $detail['document_details'],
                    ]);
                }
            } else {

                LegalDocumentDetail::create([
                    'legal_document_id' => $legalDocument->id,
                    'statement_giver' => $detail['statement_giver'],
                    'party_name' => $detail['party_name'],
                    'document_writer_name' => $detail['document_writer_name'],
                    'document_date' => $detail['document_date'],
                    'document_details' => $detail['document_details'],
                ]);
            }
        }
        if (!empty($this->deletedDetailIds)) {
            LegalDocumentDetail::whereIn('id', $this->deletedDetailIds)->delete();
        }
    }
    public function resetModal()
    {
        $this->legalDocumentDetail = [];
        $this->editIndex = null;
    }
}
