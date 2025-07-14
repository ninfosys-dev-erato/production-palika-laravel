<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\BusinessRegistration\DTO\BusinessRenewalDocumentAdminDto;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;
use Src\BusinessRegistration\Service\BusinessRenewalDocumentAdminService;

class BusinessRenewalDocumentForm extends Component
{
    use SessionFlash;

    public ?BusinessRenewalDocument $businessRenewalDocument;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'businessRenewalDocument.business_registration_id' => ['required'],
            'businessRenewalDocument.business_renewal' => ['required'],
            'businessRenewalDocument.document_name' => ['required'],
            'businessRenewalDocument.document' => ['required'],
            'businessRenewalDocument.document_details' => ['required'],
            'businessRenewalDocument.document_status' => ['required'],
            'businessRenewalDocument.comment_log' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'businessRenewalDocument.business_registration_id.required' => __('businessregistration::businessregistration.business_registration_id_is_required'),
            'businessRenewalDocument.business_renewal.required' => __('businessregistration::businessregistration.business_renewal_is_required'),
            'businessRenewalDocument.document_name.required' => __('businessregistration::businessregistration.document_name_is_required'),
            'businessRenewalDocument.document.required' => __('businessregistration::businessregistration.document_is_required'),
            'businessRenewalDocument.document_details.required' => __('businessregistration::businessregistration.document_details_is_required'),
            'businessRenewalDocument.document_status.required' => __('businessregistration::businessregistration.document_status_is_required'),
            'businessRenewalDocument.comment_log.required' => __('businessregistration::businessregistration.comment_log_is_required'),
        ];
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.business-renewal-documents-form");
    }

    public function mount(BusinessRenewalDocument $businessRenewalDocument, Action $action)
    {
        $this->businessRenewalDocument = $businessRenewalDocument;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = BusinessRenewalDocumentAdminDto::fromLiveWireModel($this->businessRenewalDocument);
            $service = new BusinessRenewalDocumentAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_renewal_document_created_successfully'));
                    return redirect()->route('admin.business_renewal_documents.index');
                    
                case Action::UPDATE:
                    $service->update($this->businessRenewalDocument, $dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_renewal_document_updated_successfully'));
                    return redirect()->route('admin.business_renewal_documents.index');

                default:
                    return redirect()->route('admin.business_renewal_documents.index');
                   
            }
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }
}
