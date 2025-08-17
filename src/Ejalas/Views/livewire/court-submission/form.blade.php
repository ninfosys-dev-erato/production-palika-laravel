<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>

                    <select wire:model='courtSubmission.complaint_registration_id' name='complaint_registration_id'
                        id="complaint_registration_id" class="form-select" wire:change="getComplaintRegistration()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_complaint') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('courtSubmission.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="reg_date" class="form-label">
                    {{ __('ejalas::ejalas.complain_registration_date') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.reg_date" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="dispute_matter_id" class="form-label">
                    {{ __('ejalas::ejalas.subject') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.subject" readonly>


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
                    <input type="text" class="form-control mb-2" value=" {{ __('ejalas::ejalas.no_complainer') }}"
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


            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='discussion_date' class="form-label">{{ __('ejalas::ejalas.discussion_date') }}</label>
                    <input wire:model='courtSubmission.discussion_date' name='discussion_date' type='text'
                        id="discussion_date" class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_discussion_date') }}">
                    <div>
                        @error('courtSubmission.discussion_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='submission_decision_date'
                        class="form-label">{{ __('ejalas::ejalas.submission_decision_date') }}</label>
                    <input wire:model='courtSubmission.submission_decision_date' name='submission_decision_date'
                        id="submission_decision_date" type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_submission_decision_date') }}">
                    <div>
                        @error('courtSubmission.submission_decision_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='decision_authority_id'
                        class="form-label">{{ __('ejalas::ejalas.decision_authority') }}</label>
                    <select wire:model='courtSubmission.decision_authority_id' name='decision_authority_id'
                        class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_decision_authority') }}</option>
                        @foreach ($judicialMembers as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='courtSubmission.decision_authority_id' name='decision_authority_id'
                        type='text' class='form-control' placeholder="{{ __('ejalas::ejalas.enter_decision_authority_id') }}"> --}}
                    <div>
                        @error('courtSubmission.decision_authority_id')
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
        <a href="{{ route('admin.ejalas.court_submissions.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

@script
    <script>
        $('#submission_decision_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('courtSubmission.submission_decision_date', nepaliDate);
        });
        $('#discussion_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('courtSubmission.discussion_date', nepaliDate);
        });
        $('#complaint_registration_id').select2();
        $('#complaint_registration_id').on('change', function(e) {
            let complaintId = $(this).val();
            @this.set('courtSubmission.complaint_registration_id', complaintId);
            @this.call('getComplaintRegistration'); // Call livewire function to get party details
        });
    </script>
@endscript
