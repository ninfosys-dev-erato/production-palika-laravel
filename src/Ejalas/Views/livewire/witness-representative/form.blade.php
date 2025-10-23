<div>
  

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $showWitnessRepresentativeForm 
                ? __('ejalas::ejalas.add_witnesses_representative') 
                : __('ejalas::ejalas.witnesses_representative_list') }}
        </h5>                    </div>
                    <div>
                    @perm('jms_judicial_management create')
        <button 
            wire:click="toggleWitnessRegistrationForm" 
            class="btn {{ $showWitnessRepresentativeForm ? 'btn-danger' : 'btn-info' }}"
        >
            <i class="bx {{ $showWitnessRepresentativeForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
            {{ $showWitnessRepresentativeForm 
                ? __('ejalas::ejalas.back') 
                : __('ejalas::ejalas.add_witnesses_representative') }}
        </button>

@endperm

                    </div>
                </div>
    @if(!$showWitnessRepresentativeForm)
      <livewire:ejalas.witnesses_representative_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else

<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
     
            <div class='col-md-6 mb-3' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <input wire:model='witnessesRepresentative.complaint_registration_id' name='complaint_registration_id' type='text' class='form-control'
                       readonly>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='name' class="form-label">{{ __('ejalas::ejalas.witness_name') }}</label>
                    <input wire:model='witnessesRepresentative.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_name') }}">
                    <div>
                        @error('witnessesRepresentative.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='address' class="form-label">{{ __('ejalas::ejalas.witness_address') }}</label>
                    <input wire:model='witnessesRepresentative.address' name='address' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_address') }}">
                    <div>
                        @error('witnessesRepresentative.address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3 mt-4'>
                <div class='form-group'>
                    <label for='is_first_party' class="form-label">{{ __('ejalas::ejalas.is_first_party') }}</label>
                    <input wire:model='witnessesRepresentative.is_first_party' name='is_first_party' type='checkbox'
                        class="form-check-input border-dark p-2 mt-1" placeholder="{{ __('ejalas::ejalas.enter_is_first_party') }}">
                    <div>
                        @error('witnessesRepresentative.is_first_party')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
    </div>
</form>
@endif
</div>