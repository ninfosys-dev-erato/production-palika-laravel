<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
        <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='extension_date' class='form-label'>{{ __('yojana::yojana.planextensionrecordextension_date') }}</label>
                    <input id="extension_date" wire:model='planExtensionRecord.extension_date' name='extension_date' type='text' class='form-control nepali-date' placeholder="{{ __('yojana::yojana.planextensionrecordextension_dateenter') }}">
                    <div>
                        @error('planExtensionRecord.extension_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
          <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='letter_submission_date' class='form-label'>{{ __('yojana::yojana.planextensionrecordletter_submission_date') }}</label>
                    <input id="letter_submission_date" wire:model='planExtensionRecord.letter_submission_date' name='letter_submission_date' type='text' class='form-control nepali-date' placeholder="{{ __('yojana::yojana.planextensionrecordletter_submission_dateenter') }}">
                    <div>
                        @error('planExtensionRecord.letter_submission_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='letter' class='form-label'>{{ __('yojana::yojana.planextensionrecordletter') }}</label>
                    <input wire:model='planExtensionRecord.letter' name='letter' type='file' class='form-control' >
                    <div>
                        @error('planExtensionRecord.letter')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
</form>

