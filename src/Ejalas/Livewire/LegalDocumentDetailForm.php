<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\LegalDocumentAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\LegalDocumentAdminService;

class LegalDocumentDetailForm extends Component
{
    use SessionFlash;

    public ?LegalDocument $legalDocument;
    public ?Action $action;
    public $complainRegistrations;
    public  $parties;

    public function rules(): array
    {
        return [
            'legalDocument.party_name' => ['required'],
            'legalDocument.document_writer_name' => ['required'],
            'legalDocument.document_signer' => ['required'],
            'legalDocument.document_date' => ['required'],
            'legalDocument.document_details' => ['required'],
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
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.legal_document_created_successfully'));
                    return redirect()->route('admin.ejalas.legal_documents.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->legalDocument, $dto);
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
}
