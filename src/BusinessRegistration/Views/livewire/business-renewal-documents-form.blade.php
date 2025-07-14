<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='business_registration_id'>{{__('businessregistration::businessregistration.business_registration_id')}}</label>
                    <input dusk="businessregistration-business_registration_id-field" wire:model='businessRenewalDocument.business_registration_id' name='business_registration_id'
                        type='text' class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_business_registration_id')}}">
                    <div>
                        @error('businessRenewalDocument.business_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='business_renewal'>{{__('businessregistration::businessregistration.business_renewal')}}</label>
                    <input dusk="businessregistration-business_renewal-field" wire:model='businessRenewalDocument.business_renewal' name='business_renewal' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_business_renewal')}}">
                    <div>
                        @error('businessRenewalDocument.business_renewal')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='document_name'>{{__('businessregistration::businessregistration.document_name')}}</label>
                    <input dusk="businessregistration-document_name-field" wire:model='businessRenewalDocument.document_name' name='document_name' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_document_name')}}">
                    <div>
                        @error('businessRenewalDocument.document_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='document'>{{__('businessregistration::businessregistration.document')}}</label>
                    <input dusk="businessregistration-document-field" wire:model='businessRenewalDocument.document' name='document' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_document')}}">
                    <div>
                        @error('businessRenewalDocument.document')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='document_details'>{{__('businessregistration::businessregistration.document_details')}}</label>
                    <input dusk="businessregistration-document_details-field" wire:model='businessRenewalDocument.document_details' name='document_details' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_document_details')}}">
                    <div>
                        @error('businessRenewalDocument.document_details')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='document_status'>{{__('businessregistration::businessregistration.document_status')}}</label>
                    <input dusk="businessregistration-document_status-field" wire:model='businessRenewalDocument.document_status' name='document_status' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_document_status')}}">
                    <div>
                        @error('businessRenewalDocument.document_status')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='comment_log'>{{__('businessregistration::businessregistration.comment_log')}}</label>
                    <input dusk="businessregistration-comment_log-field" wire:model='businessRenewalDocument.comment_log' name='comment_log' type='text'
                        class='form-control' placeholder="{{__('businessregistration::businessregistration.enter_comment_log')}}">
                    <div>
                        @error('businessRenewalDocument.comment_log')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('businessregistration::businessregistration.save')}}</button>
        <a href="{{route('admin.business_renewal_documents.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('businessregistration::businessregistration.back')}}</a>
    </div>
</form>