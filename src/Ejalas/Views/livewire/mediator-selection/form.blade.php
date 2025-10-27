<div>
  

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $showMediatorForm 
                ? __('ejalas::ejalas.add_mediator_selection') 
                : __('ejalas::ejalas.mediator_selection_list') }}
        </h5>                    </div>
                    <div>
                    @perm('jms_judicial_management create')
    @if($canAddMediator || $showMediatorForm)
        <button 
            wire:click="toggleMediatorSelectionForm" 
            class="btn {{ $showMediatorForm ? 'btn-danger' : 'btn-info' }}"
        >
            <i class="bx {{ $showMediatorForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
            {{ $showMediatorForm 
                ? __('ejalas::ejalas.back') 
                : __('ejalas::ejalas.add_mediator_selection') }}
        </button>
    @endif
@endperm

                    </div>
                </div>
    @if(!$showMediatorForm)
      <livewire:ejalas.mediator_selection_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else
<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
   <div class='col-md-6 mb-3' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <input wire:model='mediatorSelection.complaint_registration_id' name='complaint_registration_id' type='text' class='form-control'
                       readonly>
                </div>
            </div>        
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='mediator_id' class="form-label">{{ __('ejalas::ejalas.mediator') }}</label>
                    <select wire:model='mediatorSelection.mediator_id' name='mediator_id' class="form-control">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_mediator') }}</option>
                        @foreach ($mediators as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mediatorSelection.mediator_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='mediator_type' class="form-label">{{ __('ejalas::ejalas.mediator_type') }}</label>
                    <select wire:model='mediatorSelection.mediator_type' name='mediator_type' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_mediator_selection_type') }}
                        </option>
                        @foreach ($mediatorSelectionTypes as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mediatorSelection.mediator_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='selection_date'
                        class="form-label">{{ __('ejalas::ejalas.mediator_selection_date') }}</label>
                    <input wire:model='mediatorSelection.selection_date' name='selection_date' id="selection_date"
                        type='string' class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_selection_date') }}">
                    <div>
                        @error('mediatorSelection.selection_date')
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

