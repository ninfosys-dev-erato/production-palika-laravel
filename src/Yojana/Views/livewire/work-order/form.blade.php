<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='date' class='form-label'>{{ __('yojana::yojana.date') }}</label>
                    <input wire:model='workOrder.date' name='date'id="date" type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_date') }}">
                    <div>
                        @error('workOrder.date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='plan_name' class='form-label'>{{ __('yojana::yojana.plan_name') }}</label>
                    <input wire:model='workOrder.plan_name' name='plan_name' value="{{ $this->plan->name }}"
                        type='text' class='form-control nepali-date'
                        placeholder="{{ __('yojana::yojana.enter_plan_name') }}">
                    <div>
                        @error('workOrder.plan_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='subject' class='form-label'>{{ __('yojana::yojana.subject') }}</label>
                    <input wire:model='workOrder.subject' name='subject' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_subject') }}">
                    <div>
                        @error('workOrder.subject')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label for='letter_body' class='form-label'>{{ __('yojana::yojana.letter_body') }}</label>
                                     <x-form.ck-editor-input id="workOrder_letter_body" wire:model='workOrder.letter_body'
                        name='workOrder.letter_body' :value="$workOrder?->letter_body ?? ''" />
                    <div>
                        @error('workOrder.letter_body')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:loading.attr="disabled">
            {{ __('yojana::yojana.back') }}
        </button>

    </div>
</form>

