<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='fiscal_year_id' class='form-label'>{{ __('ejalas::ejalas.fiscal_year') }}</label>
                    {{-- <input wire:model='judicialMeeting.fiscal_year_id' name='fiscal_year_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_fiscal_year_id') }}"> --}}
                    <select wire:model='judicialMeeting.fiscal_year_id' name='fiscal_year_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_option') }}</option>
                        @foreach ($fiscalYears as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('judicialMeeting.fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='meeting_date' class='form-label'>{{ __('ejalas::ejalas.meeting_date') }}</label>
                    <input wire:model='judicialMeeting.meeting_date' id="meeting_date" name='meeting_date'
                        type='text' class='form-control' placeholder="{{ __('ejalas::ejalas.enter_meeting_date') }}">
                    <div>
                        @error('judicialMeeting.meeting_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='meeting_time' class='form-label'>{{ __('ejalas::ejalas.meeting_time') }}</label>
                    <input wire:model='judicialMeeting.meeting_time' name='meeting_time' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_meeting_time') }}">
                    <div>
                        @error('judicialMeeting.meeting_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='meeting_number' class='form-label'>{{ __('ejalas::ejalas.meeting_number') }}</label>
                    <input wire:model='judicialMeeting.meeting_number' name='meeting_number' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_meeting_number') }}">
                    <div>
                        @error('judicialMeeting.meeting_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-2'>
                <div class='form-group'>
                    <label for='decision_number' class='form-label'>{{ __('ejalas::ejalas.decision_number') }}</label>
                    <input wire:model='judicialMeeting.decision_number' name='decision_number' type='number'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_decision_number') }}">
                    <div>
                        @error('judicialMeeting.decision_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-2' wire:ignore>
                <div class='form-group'>
                    <label for='invited_employee_id'
                        class='form-label'>{{ __('ejalas::ejalas.invited_employee') }}</label>
                    <select wire:model="invited_employee_ids" id="invited_employee_id" class="form-control select2"
                        multiple>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_option') }}</option>
                        @foreach ($judicialMembers as $id => $key)
                            <option value="{{ $id }}">{{ $key }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('invited_employee_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-2' wire:ignore>
                <div class='form-group'>
                    <label for='members_present_id'
                        class='form-label'>{{ __('ejalas::ejalas.members_present') }}</label>
                    <select wire:model="members_present_ids" id="members_present_id" class="form-control select2"
                        multiple>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_option') }}</option>
                        @foreach ($judicialEmployees as $id => $key)
                            <option value="{{ $id }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('members_present_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class='col-md-12 mb-3'>
                <div class='form-group'>

                    <x-form.ck-editor-input id="judicialMeeting_meeting_topic"
                        label="{{ __('ejalas::ejalas.meeting_topic') }}" wire:model='judicialMeeting.meeting_topic'
                        name='judicialMeeting.meeting_topic' :value="$judicialMeeting?->meeting_topic ?? ''" />

                    <div>
                        @error('judicialMeeting.meeting_topic')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 mb-3'>
                <div class='form-group'>

                    <x-form.ck-editor-input label="{{ __('ejalas::ejalas.decision_details') }}"
                        id="judicialMeeting_decision_details" wire:model='judicialMeeting.decision_details'
                        name='judicialMeeting.decision_details' :value="$judicialMeeting?->decision_details ?? ''" />
                    <div>
                        @error('judicialMeeting.decision_details')
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
        <a href="{{ route('admin.ejalas.judicial_meetings.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>



<script>
    $(document).ready(function() {

        $('#meeting_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('judicialMeeting.meeting_date', nepaliDate);
        });

        $('#invited_employee_id').select2().on('change', function() {
            let selected = $(this).val(); // array of selected values
            @this.set('invited_employee_ids', selected);
        });

        // Select2 for members_present_id
        $('#members_present_id').select2().on('change', function() {
            let selected = $(this).val(); // array of selected values
            @this.set('members_present_ids', selected);
        });
    });
</script>
