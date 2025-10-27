<div>
  

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $showResponseForm 
                ? __('ejalas::ejalas.add_hearing_schedule') 
                : __('ejalas::ejalas.hearing_schedule_list') }}
        </h5>                    </div>
                    <div>
                    @perm('jms_judicial_management create')
    @if($canAddResponse || $showResponseForm)
        <button 
            wire:click="toggleResponseRegistrationForm" 
            class="btn {{ $showResponseForm ? 'btn-danger' : 'btn-info' }}"
        >
            <i class="bx {{ $showResponseForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
            {{ $showResponseForm 
                ? __('ejalas::ejalas.back') 
                : __('ejalas::ejalas.add_hearing_schedule') }}
        </button>
    @endif
@endperm

                    </div>
                </div>
    @if(!$showResponseForm)
      <livewire:ejalas.written_response_registration_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else
<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='response_registration_no'
                        class="form-label">{{ __('ejalas::ejalas.response_registration_no') }}</label>
                    <input wire:model='writtenResponseRegistration.response_registration_no'
                        name='response_registration_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_response_registration_no') }}" readonly>
                    <div>
                        @error('writtenResponseRegistration.response_registration_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <input wire:model='writtenResponseRegistration.complaint_registration_id' name='complaint_registration_id' type='text' class='form-control'
                       readonly>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='registration_date'
                        class="form-label">{{ __('ejalas::ejalas.registration_date') }}</label>
                    <input wire:model='writtenResponseRegistration.registration_date' id="registration_date"
                        name='registration_date' type='string' class='form-control nepali-date'>
                    <div>
                        @error('writtenResponseRegistration.registration_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_amount' class="form-label">{{ __('ejalas::ejalas.fee_amount') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_amount' name='fee_amount' type='number'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_fee_amount') }}">
                    <div>
                        @error('writtenResponseRegistration.fee_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_receipt_no' class="form-label">{{ __('ejalas::ejalas.fee_receipt_no') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_receipt_no' name='fee_receipt_no' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_fee_receipt_no') }}">
                    <div>
                        @error('writtenResponseRegistration.fee_receipt_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_paid_date' class="form-label">{{ __('ejalas::ejalas.fee_paid_date') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_paid_date' id="fee_paid_date"
                        name='fee_paid_date' type='string' class='form-control nepali-date'>
                    <div>
                        @error('writtenResponseRegistration.fee_paid_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='description' class="form-label">{{ __('ejalas::ejalas.description') }}</label>
                    <textarea wire:model='writtenResponseRegistration.description' name='description' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_description') }}" rows="5"></textarea>
                    <div>
                        @error('writtenResponseRegistration.description')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='claim_request' class="form-label">{{ __('ejalas::ejalas.claim_request') }}</label>
                    <textarea wire:model='writtenResponseRegistration.claim_request' name='claim_request' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_claim_request') }}" rows="5"></textarea>
                    <div>
                        @error('writtenResponseRegistration.claim_request')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-3">

                <div class="divider divider-primary text-start text-primary">
                    <div class="divider-text fw-bold fs-6">
                        {{ __('ejalas::ejalas.eligibility_indicators_for_registration') }}
                    </div>
                </div>


                <ol class="list-unstyled">
                    @foreach ($registrationIndicators as $id => $value)
                        <li class="row mb-3 align-items-center">
                            <div class="col-md-9">
                                <label class="fw-bold mb-0">{{ $value }}</label>
                            </div>
                            <div class="col-md-3 d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="full_{{ $id }}" value="पूरा भएको">
                                    <label class="form-check-label" for="full_{{ $id }}">पूरा
                                        भएको</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="not_full_{{ $id }}" value="पूरा नभएको">
                                    <label class="form-check-label" for="not_full_{{ $id }}">पूरा
                                        नभएको</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="not_applicable_{{ $id }}" value="लागु नहुने">
                                    <label class="form-check-label" for="not_applicable_{{ $id }}">लागु
                                        नहुने</label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <hr>
            <div class="d-flex justify-content-end">
                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label for='status' class="form-label">{{ __('ejalas::ejalas.status') }}</label>
                        <select wire:model='writtenResponseRegistration.status' name='status' class='form-select'
                            disabled>
                            <option value="Rejected">{{ __('ejalas::ejalas.rejected') }}</option>
                            <option value="Approved">{{ __('ejalas::ejalas.approved') }}</option>
                        </select>
                        <div>
                            @error('writtenResponseRegistration.status')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
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

