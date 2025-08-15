<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_eng'>{{ __('beruju::beruju.name_eng') }}</label>
                    <input wire:model='documentType.name_eng' name='name_eng' type='text' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_document_type_name_eng') }}">
                    <div> @error('documentType.name_eng') <small class='text-danger'>{{ __($message) }}</small> @enderror </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_nep'>{{ __('beruju::beruju.name_nep') }} <span class="text-danger">*</span></label>
                    <input wire:model='documentType.name_nep' name='name_nep' type='text' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_document_type_name_nep') }}" required>
                    <div> @error('documentType.name_nep') <small class='text-danger'>{{ __($message) }}</small> @enderror </div>
                </div>
            </div>
            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='remarks'>{{ __('beruju::beruju.remarks') }}</label>
                    <textarea wire:model='documentType.remarks' name='remarks' class='form-control' rows='3'
                        placeholder="{{ __('beruju::beruju.enter_remarks') }}"></textarea>
                    <div> @error('documentType.remarks') <small class='text-danger'>{{ __($message) }}</small> @enderror </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary border-radius-0">
                <i class="fas fa-save"></i> 
                {{ $action === \App\Enums\Action::CREATE ? __('beruju::beruju.create') : __('beruju::beruju.update') }}
            </button>
        </div>
    </div>
</form>
