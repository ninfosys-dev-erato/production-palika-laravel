<div>

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $showDisputeDeadlineForm 
                ? __('ejalas::ejalas.add_dispute_deadline') 
                : __('ejalas::ejalas.dispute_deadline_list') }}
        </h5>                    </div>
                    <div>
                           @perm('jms_judicial_management create')
            <button 
                wire:click="toggleDisputeDeadlineForm" 
                class="btn {{ $showDisputeDeadlineForm ? 'btn-danger' : 'btn-info' }}"
            >
                <i class="bx {{ $showDisputeDeadlineForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                {{ $showDisputeDeadlineForm 
                    ? __('ejalas::ejalas.back') 
                    : __('ejalas::ejalas.add_dispute_deadline') }}
            </button>
        @endperm
                    </div>
                </div>
    @if(!$showDisputeDeadlineForm)
        <livewire:ejalas.dispute_deadline_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else

<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="complaint_registration_id" class="form-label">
                        {{ __('ejalas::ejalas.complaint_registration_no') }}
                    </label>
                   <input type="text" class="form-control" wire:model='disputeDeadline.complaint_registration_id'
                         readonly>
                </div>
   
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='registrar_id' class="form-label">{{ __('ejalas::ejalas.registrar') }}</label>

                    <select wire:model='disputeDeadline.registrar_id' name='registrar_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_an_employee_name') }}</option>
                        @foreach ($registerEmployees as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('disputeDeadline.registrar_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deadline_set_date'
                        class="form-label">{{ __('ejalas::ejalas.deadline_set_date') }}</label>
                    <input wire:model='disputeDeadline.deadline_set_date' id="deadline_set_date"
                        name='deadline_set_date' type='text' class='nepali-date form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_deadline_set_date') }}">
                    <div>
                        @error('disputeDeadline.deadline_set_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deadline_extension_period'
                        class="form-label">{{ __('ejalas::ejalas.deadline_extension_period') }}</label>
                    <input wire:model='disputeDeadline.deadline_extension_period' name='deadline_extension_period'
                        type='number' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_deadline_extension_period') }}">
                    <div>
                        @error('disputeDeadline.deadline_extension_period')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
       
    </div>
</form>
@endif
</div>

