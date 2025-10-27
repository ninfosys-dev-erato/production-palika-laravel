<div>
    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between card-header">
            <h5 class="text-primary fw-bold mb-0">
                {{ $showLegalDocumentForm 
                    ? __('ejalas::ejalas.add_legal_document') 
                    : __('ejalas::ejalas.legal_document_list') }}
            </h5>
        </div>

        <div>
            @perm('jms_judicial_management create')
                <button 
                    wire:click="toggleLegalDocumentForm" 
                    class="btn {{ $showLegalDocumentForm ? 'btn-danger' : 'btn-info' }}"
                >
                    <i class="bx {{ $showLegalDocumentForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                    {{ $showLegalDocumentForm 
                        ? __('ejalas::ejalas.back') 
                        : __('ejalas::ejalas.add_legal_document') }}
                </button>
            @endperm
        </div>
    </div>

    @if(!$showLegalDocumentForm)
        <livewire:ejalas.legal_document_table 
            theme="bootstrap-4" 
            :complaintRegistration="$complaintRegistration" 
        /> 
    @else
        <form wire:submit.prevent="save">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="complaint_registration_id" class="form-label">
                                {{ __('ejalas::ejalas.complaint_no') }}
                            </label>
                            <input 
                                wire:model="legalDocument.complaint_registration_id" 
                                name="complaint_registration_id" 
                                type="text" 
                                class="form-control" 
                                readonly
                            >
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 ">
                        <div class="form-group">
                            <label for="party_name" class="form-label">
                                {{ __('ejalas::ejalas.party_name') }}
                            </label>
                            <select 
                                wire:model="legalDocument.party_name" 
                                name="party_name" 
                                class="form-select"
                            >
                                <option value="" hidden>
                                    {{ __('ejalas::ejalas.select_a_party_name') }}
                                </option>
                                @forelse ($parties as $party)
                                    <option value="{{ $party['id'] }}">
                                        {{ $party['name'] }} ({{ ucfirst($party['type']) }})
                                    </option>
                                @empty
                                    <option value="" disabled>
                                        {{ __('ejalas::ejalas.no_value_available') }}
                                    </option>
                                @endforelse
                            </select>
                            <div>
                                @error('legalDocument.party_name')
                                    <small class="text-danger">{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="document_date" class="form-label">
                                {{ __('ejalas::ejalas.document_date') }}
                            </label>
                            <input 
                                wire:model="legalDocument.document_date"
                                id="document_date"
                                name="document_date" 
                                type="text" 
                                class="form-control nepali-date"
                                placeholder="{{ __('ejalas::ejalas.enter_document_date') }}"
                            >
                            <div>
                                @error('legalDocument.document_date')
                                    <small class="text-danger">{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="document_writer_name" class="form-label">
                                {{ __('ejalas::ejalas.document_writer_name') }}
                            </label>
                            <input 
                                wire:model="legalDocument.document_writer_name" 
                                name="document_writer_name"
                                type="text" 
                                class="form-control"
                                placeholder="{{ __('ejalas::ejalas.enter_document_writer_name') }}"
                            >
                            <div>
                                @error('legalDocument.document_writer_name')
                                    <small class="text-danger">{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="document_details" class="form-label">
                                {{ __('ejalas::ejalas.legal_document_detail') }}
                            </label>
                            <textarea
                                id="legalDocument_document_details"
                                wire:model="legalDocument.document_details"
                                name="legalDocument.document_details"
                                class="form-control"
                                rows="5"
                                placeholder="{{ __('ejalas::ejalas.legal_document_detail') }}"
                            ></textarea>
                            <div>
                                @error('legalDocument.document_details')
                                    <small class="text-danger">{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button 
                    type="submit" 
                    class="btn btn-primary"
                    wire:loading.attr="disabled"
                >
                    {{ __('ejalas::ejalas.save') }}
                </button>
            </div>
        </form>
    @endif
</div>
