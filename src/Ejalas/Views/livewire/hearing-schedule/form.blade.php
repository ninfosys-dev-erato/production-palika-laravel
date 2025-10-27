<div>

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $hearingScheduleForm 
                ? __('ejalas::ejalas.add_hearing_schedule') 
                : __('ejalas::ejalas.hearing_schedule_list') }}
        </h5>                    </div>
                    <div>
                           @perm('jms_judicial_management create')
            <button 
                wire:click="toggleHearingScheduleForm" 
                class="btn {{ $hearingScheduleForm ? 'btn-danger' : 'btn-info' }}"
            >
                <i class="bx {{ $hearingScheduleForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                {{ $hearingScheduleForm 
                    ? __('ejalas::ejalas.back') 
                    : __('ejalas::ejalas.add_hearing_schedule') }}
            </button>
        @endperm
                    </div>
                </div>
    @if(!$hearingScheduleForm)
      <livewire:ejalas.hearing_schedule_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else

<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
                <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <input wire:model='hearingSchedule.complaint_registration_id' name='complaint_registration_id' type='text' class='form-control'
                       readonly>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='hearing_paper_no' class="form-label">{{ __('ejalas::ejalas.hearing_paper_no') }}</label>
                    <input wire:model='hearingSchedule.hearing_paper_no' name='hearing_paper_no' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_hearing_record') }}" readonly>
                    <div>
                        @error('hearingSchedule.hearing_paper_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fiscal_year_id' class="form-label">{{ __('ejalas::ejalas.fiscal_year') }}</label>
                    <select wire:model='hearingSchedule.fiscal_year_id' name='fiscal_year_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_fiscal_year') }}</option>
                        @foreach ($fiscalYears as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('hearingSchedule.fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
      
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='hearing_date' class="form-label">{{ __('ejalas::ejalas.hearing_date') }}</label>
                    <input wire:model='hearingSchedule.hearing_date' id="hearing_date" name='hearing_date'
                        type='string' class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_hearing_date') }}">
                    <div>
                        @error('hearingSchedule.hearing_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='hearing_time' class="form-label">{{ __('ejalas::ejalas.hearing_time') }}</label>
                    <input wire:model='hearingSchedule.hearing_time' name='hearing_time' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_hearing_time') }}">
                    <div>
                        @error('hearingSchedule.hearing_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='reference_no' class="form-label">{{ __('ejalas::ejalas.ejalashreferenceno') }}</label>
                    <input wire:model='hearingSchedule.reference_no' name='reference_no' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_reference_no') }}">
                    <div>
                        @error('hearingSchedule.reference_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='reconciliation_center_id'
                        class="form-label">{{ __('ejalas::ejalas.reconciliation_center') }}</label>
                    <select wire:model='hearingSchedule.reconciliation_center_id' name='reconciliation_center_id'
                        class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_reconciliation_center') }}</option>
                        @foreach ($reconciliationCenters as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('hearingSchedule.reconciliation_center_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text fw-bold fs-6">{{ __('ejalas::ejalas.description') }}</div>
            </div>
           
             <div class="col-md-6 mb-3">
                <label for="complainer_id" class="form-label">
                    {{ __('ejalas::ejalas.complainers') }}
                </label>
       @forelse ($complaintRegistration->complainers as $complainer)
                    <input type="text" class="form-control mb-2" value="{{ $complainer->name }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_complainer') }}"
                        readonly>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <label for="defender_id" class="form-label">
                    {{ __('ejalas::ejalas.defenders') }}
                </label>
               @forelse ($complaintRegistration->defenders as $defender)
                    <input type="text" class="form-control mb-2" value="{{ $defender->name }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_defender') }}"
                        readonly>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <label for="claim request" class="form-label">
                    {{ __('ejalas::ejalas.claim_request') }}
                </label>
                <input type="text" class="form-control" readonly value="{{ $complaintRegistration->claim_request }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="subject" class="form-label">
                    {{ __('ejalas::ejalas.subject') }}
                </label>
                <input type="text" class="form-control" value="{{ $complaintRegistration->subject }}" readonly>
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
