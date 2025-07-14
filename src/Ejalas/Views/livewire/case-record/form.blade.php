<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>
                    <select wire:model='caseRecord.complaint_registration_id' name='complaint_registration_id'
                        id="complaint_registration_id" class="form-select" wire:change="getComplaintRegistration()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_complaint') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('caseRecord.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fiscal_year" class="form-label">
                    {{ __('ejalas::ejalas.fiscal_year') }}
                </label>
                <input type="text" class="form-control" value="{{ $complaintData['fiscal_year']['year'] ?? 'N/A' }}"
                    readonly>

            </div>

            <div class="col-md-6 mb-3">
                <label for="reg_date" class="form-label">
                    {{ __('ejalas::ejalas.complain_registration_date') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.reg_date" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="reg_date" class="form-label">
                    {{ __('ejalas::ejalas.priority') }}
                </label>
                <input type="text" class="form-control" value="{{ $complaintData['priority']['name'] ?? 'N/A' }}"
                    readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="dispute_matter_id" class="form-label">
                    {{ __('ejalas::ejalas.dispute_matter') }}
                </label>
                <input type="text" class="form-control"
                    value="{{ $complaintData['dispute_area']['title_en'] ?? 'N/A' }}" readonly>


            </div>
            <div class="col-md-6 mb-3">
                <label for="claim request" class="form-label">
                    {{ __('ejalas::ejalas.claim_request') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.claim_request" readonly>
            </div>


            <div class="col-md-6 mb-3">
                <label for="complainer_id" class="form-label">
                    {{ __('ejalas::ejalas.complainers') }}
                </label>
                @forelse ($complainers as $complainer)
                    <input type="text" class="form-control mb-2" value="{{ $complainer }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_complainer') }}"
                        readonly>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <label for="defender_id" class="form-label">
                    {{ __('ejalas::ejalas.defenders') }}
                </label>
                @forelse ($defenders as $defender)
                    <input type="text" class="form-control mb-2" value="{{ $defender }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_defender') }}"
                        readonly>
                @endforelse
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
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='remarks' class="form-label">{{ __('ejalas::ejalas.case_remark') }}</label>
                    <input wire:model='caseRecord.remarks' name='remarks' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_remarks') }}">
                    <div>
                        @error('caseRecord.remarks')
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
        <a href="{{ route('admin.ejalas.case_records.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

@script
    <script>
        $('#discussion_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('caseRecord.discussion_date', nepaliDate);
        });
        $('#decision_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('caseRecord.decision_date', nepaliDate);
        });

        $('#complaint_registration_id').select2();
        $('#complaint_registration_id').on('change', function(e) {
            let complaintId = $(this).val();
            @this.set('caseRecord.complaint_registration_id', complaintId);
            @this.call('getComplaintRegistration'); // Call livewire function to get party details
        });
    </script>
@endscript
