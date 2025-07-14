<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='notice_no' class="form-label ">{{ __('ejalas::ejalas.notice_no') }}</label>
                    <input wire:model='courtNotice.notice_no' name='notice_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_notice_no') }}" readonly>
                    <div>
                        @error('courtNotice.notice_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fiscal_year_id' class="form-label ">{{ __('ejalas::ejalas.fiscal_year') }}</label>

                    <select name="" id="" class="form-select" wire:model="courtNotice.fiscal_year_id">
                        <option value=""hidden>{{ __('Select an option') }}</option>
                        @foreach ($fiscalYears as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('courtNotice.fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <select wire:model='courtNotice.complaint_registration_id' id="complaint_registration_id"
                        name='complaint_registration_id' class="form-select" wire:change="getComplaintRegistration()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_registration_number') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('courtNotice.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='reference_no' class="form-label ">{{ __('ejalas::ejalas.reference_no') }}</label>
                    <input wire:model='courtNotice.reference_no' name='reference_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_reference_no') }}" readonly>
                    <div>
                        @error('courtNotice.reference_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='notice_date' class="form-label ">{{ __('ejalas::ejalas.notice_date') }}</label>
                    <input wire:model='courtNotice.notice_date' id="notice_date" name='notice_date' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_notice_date') }}">
                    <div>
                        @error('courtNotice.notice_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='notice_time' class="form-label ">{{ __('ejalas::ejalas.notice_time') }}</label>
                    <input wire:model='courtNotice.notice_time' name='notice_time' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_notice_time') }}" readonly>
                    <div>
                        @error('courtNotice.notice_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='reconciliation_center_id'
                        class="form-label ">{{ __('ejalas::ejalas.reconciliation_center') }}</label>
                    <select wire:model='courtNotice.reconciliation_center_id' name='reconciliation_center_id'
                        class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_reconciliation_center') }}</option>
                        @foreach ($reconciliationCenters as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='hearingSchedule.reconciliation_center_id' name='reconciliation_center_id'
                        type='text' class='form-control' placeholder="{{ __('ejalas::ejalas.enter_reconciliation_center_id') }}"> --}}
                    <div>
                        @error('courtNotice.reconciliation_center_id')
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
        <a href="{{ route('admin.ejalas.court_notices.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            $('#notice_date').nepaliDatePicker({
                dateFormat: '%y-%m-%d',
                closeOnDateSelect: true,
            }).on('dateSelect', function() {
                let nepaliDate = $(this).val();
                @this.set('courtNotice.notice_date', nepaliDate);
            });
            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('courtNotice.complaint_registration_id', complaintId);
                @this.call('getComplaintRegistration');
            });
        });
    </script>
@endscript
