<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
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
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <select wire:model='hearingSchedule.complaint_registration_id' id="complaint_registration_id"
                        name='complaint_registration_id' class="form-select" wire:change="getComplaintRegistration()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_registration_number') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
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

            <div class="col-md-6 mb-3">
                <label for="claim request" class="form-label">
                    {{ __('ejalas::ejalas.claim_request') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.claim_request" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="subject" class="form-label">
                    {{ __('ejalas::ejalas.subject') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.subject" readonly>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.hearing_schedules.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
@script
    <script>
        $(document).ready(function() {

            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('hearingSchedule.complaint_registration_id', complaintId);
                @this.call('getComplaintRegistration');
            });
        });
    </script>
@endscript
