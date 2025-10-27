<div>
  

        <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
        <h5 class="text-primary fw-bold mb-0">
            {{ $showCaseRecordForm 
                ? __('ejalas::ejalas.add_case_record') 
                : __('ejalas::ejalas.case_record_list') }}
        </h5>                    </div>
                    <div>
                    @perm('jms_judicial_management create')
    @if($canCaseRecord || $showCaseRecordForm)
        <button 
            wire:click="toggleCaseRecordForm" 
            class="btn {{ $showCaseRecordForm ? 'btn-danger' : 'btn-info' }}"
        >
            <i class="bx {{ $showCaseRecordForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
            {{ $showCaseRecordForm 
                ? __('ejalas::ejalas.back') 
                : __('ejalas::ejalas.add_case_record') }}
        </button>
    @endif
@endperm

                    </div>
                </div>
    @if(!$showCaseRecordForm)
        <livewire:ejalas.case_record_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration"/> 
@else

<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
          <div class='col-md-6 mb-3' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <input wire:model='caseRecord.complaint_registration_id' name='complaint_registration_id' type='text' class='form-control'
                       readonly>
                </div>
            </div>   
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='discussion_date' class="form-label">{{ __('ejalas::ejalas.discussion_date') }}</label>
                    <input wire:model='caseRecord.discussion_date' name='discussion_date' type='text'
                        id="discussion_date" class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_discussion_date') }}">
                    <div>
                        @error('caseRecord.discussion_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='decision_date' class="form-label">{{ __('ejalas::ejalas.decision_date') }}</label>
                    <input wire:model='caseRecord.decision_date' name='decision_date' type='text' id="decision_date"
                        class='form-control nepali-date' placeholder="{{ __('ejalas::ejalas.enter_decision_date') }}">
                    <div>
                        @error('caseRecord.decision_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='decision_authority_id'
                        class="form-label">{{ __('ejalas::ejalas.decision_authority') }}</label>
                    <select wire:model='caseRecord.decision_authority_id' name='decision_authority_id'
                        class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_decision_authority') }}</option>
                        @foreach ($judicialMembers as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='caseRecord.decision_authority_id' name='decision_authority_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_decision_authority') }}"> --}}
                    <div>
                        @error('caseRecord.decision_authority_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='recording_officer_name'
                        class="form-label">{{ __('ejalas::ejalas.recording_officer_name') }}</label>
                    <select wire:model='caseRecord.recording_officer_name' name='recording_officer_name'
                         class="form-select" wire:change="getJudicialEmployeePosition()">
                                              

                        <option value="" hidden>{{ __('ejalas::ejalas.select_recording_officer_name') }}
                        </option>
                        @foreach ($judicialEmployees as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('caseRecord.recording_officer_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='recording_officer_position'
                        class="form-label">{{ __('ejalas::ejalas.recording_officer_position') }}</label>
                    <input wire:model='caseRecord.recording_officer_position' name='recording_officer_position'
                        type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_recording_officer_position') }}" readonly>
                    <div>
                        @error('caseRecord.recording_officer_position')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label for='remarks' class="form-label">{{ __('ejalas::ejalas.case_remark') }}</label>
              <textarea wire:model="caseRecord.remarks" 
          name="remarks" 
          class="form-control" 
          placeholder="{{ __('ejalas::ejalas.enter_remarks') }}" 
          rows="4"></textarea>

                    <div>
                        @error('caseRecord.remarks')
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
        <a href="{{ route('admin.ejalas.case_records.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
@endif
</div>
